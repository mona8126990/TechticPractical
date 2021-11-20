<?php
namespace App\Helpers;

class Helper
{
    /**
     * To retrive result in array
     *
     * @param $status
     * @param null $title
     * @param null $data
     * @param null $message
     * @return array
     */
    public static function getReturnStatus($status, $title = null, $data = null, $message = null)
    {
        // To return result in array
        return [
            'status' => $status,
            'title' => $title,
            'data' => $data,
            'message' => $message,
        ];

    }
}
?>
