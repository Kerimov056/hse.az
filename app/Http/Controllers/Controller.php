<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * KÖK HƏLL: Route parametrlərindən 'locale'-ni bir dəfəlik kəsib atırıq ki,
     * controller metodları '$locale' tələb etməsin.
     */
    public function callAction($method, $parameters)
    {
        // Route param adları ilə gələ bilər
        if (is_array($parameters)) {
            // Ad ilə verilmişdirsə (associative)
            if (array_key_exists('locale', $parameters)) {
                unset($parameters['locale']);
            } else {
                // Rəqəm indeksli gələ bilər: ilk arqument locale stringidirsə, atırıq
                $first = reset($parameters);
                if (is_string($first) && in_array($first, ['az', 'en', 'ru'], true)) {
                    array_shift($parameters);
                }
            }
        }

        return parent::callAction($method, $parameters);
    }
}
