<script>
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var task = @json($taskFields);

       console.log(task);

        $('#calendar').fullCalendar({
            header: {
                left: 'prev, next today',
                center: 'title',
                right: 'month, agendaWeek, agendaDay',
            },
            events: task,
            selectable: true,
            selectHelper: true,
            unselectAuto: false,

            select: function (start, end, allDays) {
                $('#bookingModal').modal('toggle');

                $('#saveBtn').click(function () {
                    var id = 1;
                    var title = $('#title').val();
                    var description = $('#description').val();
                    var start_date = moment(start).format('YYYY-MM-DD');
                    var end_date = moment(end).format('YYYY-MM-DD');
                    var test = $('#test').val();

                    $.ajax({
                        url: "{{ route('calendar.store') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {id, title, description, start_date, end_date,test},
                        success: function (response) {
                            $('#bookingModal').modal('hide')
                            $('#calendar').fullCalendar('renderEvent', {
                                'id': response.id,
                                'title': response.title,
                                'description': response.description,
                                'start': response.start,
                                'end': response.end,
                                'test': response.test,
                                'color': response.color
                            });
                            console.log(response.test);
                            swal( "Zadanie zostało dodane");
                        },
                        error: function (error) {
                            if (error.responseJSON.errors) {
                                $('#titleError').html(error.responseJSON.errors.title);
                                $('#descriptionError').html(error.responseJSON.errors.description);
                                $('#testError').html(error.responseJSON.errors.test);
                            }
                        },
                    });

                });
            },
            editable: true,

            eventClick: function (event) {
                var id = event.id;

                if (confirm('Czy chesz przeglądnąć zadanie ?')) {
                    window.location.href = "{{ route('calendar.task','') }}" + '/' + id;
                }
            },

            selectAllow: function (event) {
                return moment(event.start).utcOffset(false).isSame(moment(event.end).subtract(1, 'second').utcOffset(false), 'day');
            },
        });


        $("#bookingModal").on("hidden.bs.modal", function () {
            $('#saveBtn').unbind();
        });
        $('.fc-time').hide();
        $('.fc-event-container').css('font-size', '15px');
        $('.fc-event-container').css('width', '30px');
        $('.fc-event-container').css('border-radius', '10%');


    });
</script>
