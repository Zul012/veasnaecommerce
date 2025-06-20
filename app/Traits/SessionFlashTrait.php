<?php

namespace App\Traits;

use Illuminate\Support\Facades\Session;

trait SessionFlashTrait
{
    /**
     * Flash a success message to the session
     *
     * @param string $message
     * @return void
     */
    protected function flashSuccess($message)
    {
        Session::flash('success', $message);
    }

    /**
     * Flash an error message to the session
     *
     * @param string $message
     * @return void
     */
    protected function flashError($message)
    {
        Session::flash('error', $message);
    }

    /**
     * Flash a warning message to the session
     *
     * @param string $message
     * @return void
     */
    protected function flashWarning($message)
    {
        Session::flash('warning', $message);
    }

    /**
     * Flash an info message to the session
     *
     * @param string $message
     * @return void
     */
    protected function flashInfo($message)
    {
        Session::flash('info', $message);
    }
}
