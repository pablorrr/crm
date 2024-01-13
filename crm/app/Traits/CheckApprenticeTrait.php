<?php

namespace App\Traits;


use App\Models\Team;
use Illuminate\Http\Request;

trait CheckApprenticeTrait
{
//todo w prsyszlosci uzyc jednego z wzorcoww prijektowych ktroy przetwarza podbne do siebie metody w jedna!
    public function checkApprentice(Request $request)
    {
        /**
         * Uwaga!!! przy testowaniu middleware nalezy sparawdzic czy zalogowany user jest w skladzie aktualnego team'u!!!
         *
         */
        $team = $request->user()->currentTeam;

        if(!empty($team))
        {
              $user = $request->user();

        if ( $user->teamRole($team)->key =='apprentice') {
            abort(401);
        }
        }
      


    }
}
