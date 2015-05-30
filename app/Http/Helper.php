<?php namespace App\Http {

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Response as Response;

    class Helpers {
        /**
         * @param Request $request
         * @param $id
         * @return bool
         */
        public static function self_permission(Request $request, $id){

            if(
                $request->user()->has_role('admin') ||
                (
                    $request->user() &&
                    $request->user()->id == $id
                )
            ) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * @return string
         */
        public static function get_full_domain(){
            return 'http://www.nepalunited.com';
        }

        /**
         * @param $base64
         * @return array($status, $image)
         */
        public static function get_image_from_base64($base64) {
            if(!preg_match('/^data:(image\/(jpeg|jpg|png));base64,(.+)/', $base64, $matches)) {
                return array(false, null);
            }
            $WIDTH = 500;
            $HEIGHT = 250;

            $mime = $matches[1];
            $base64img = $matches[3];

            $img = imagecreatefromstring(base64_decode($base64img));
            if (!$img) {
                return array(false, null);
            }
            $image_prefix = tempnam(storage_path(),'tmp_'.uniqid());
            $tempimage = null;
            if(in_array($mime, ['image/jpg', 'image/jpeg'])){
                $tempimage = $image_prefix.'.jpg';
                imagejpeg($img, $tempimage);
            } else {
                $tempimage = $image_prefix.'.png';
                imagepng($img, $tempimage);
            }
            $info = getimagesize($tempimage);
            unlink($tempimage);

            if ($info[0] > 0 && $info[1] > 0 && ($info['mime'] && $info['mime'] == $mime)) {
                $thumb = imagecreatetruecolor($WIDTH, $HEIGHT);
                imagecopyresized($thumb, $img, 0, 0, 0, 0, $WIDTH, $HEIGHT, $info[0], $info[1]);
                return array(true, $thumb);
            }

            return array(false, null);
        }
    }

    class ApiResponse extends Response
    {

        /**
         * @param array $data
         * @param array $headers
         * @return mixed
         */
        public static function success($data = array(), $headers = array()){
            return self::json($data, '200', $headers, $options=JSON_PRETTY_PRINT);
        }

        /**
         * @param array $data
         * @param array $headers
         * @return mixed
         */
        public static function created($data = array(), $headers = array()){
            return self::json($data, '201', $headers, $options=JSON_PRETTY_PRINT);
        }

        /**
         * @param array $headers
         * @return mixed
         */
        public static function deleted($headers = array()){
            return self::json(null, '204', $headers, $options=JSON_PRETTY_PRINT);
        }

        /**
         *	Similar to 403 Forbidden, but specifically for use when authentication is required and
         *  has failed or has not yet been provided. The response must include a WWW-Authenticate header field
         *  containing a challenge applicable to the requested resource.
         *	@param array|string $date Message to format
         *	@param array $headers Additional header to append to the request
         * 	@return ApiResponse JSON representation of the error message
         */
        public static function errorUnauthorized($data = array(), $headers = array())
        {
            return self::json($data, '401', $headers, $options=JSON_PRETTY_PRINT);
        }

        /**
         *    The request was a valid request, but the server is refusing to respond to it.
         *    Unlike a 401 Unauthorized response, authenticating will make no difference.
         * @param array|string $date Message to format
         * @param array $headers Additional header to append to the request
         * @return ApiResponse JSON representation of the error message
         */
        public static function errorForbidden($data = array(), $headers = array())
        {
            return self::json($data, '403', $headers, $options=JSON_PRETTY_PRINT);
        }

        /**
         *    The requested resource could not be found but may be available again in the future.
         *    Subsequent requests by the client are permissible.
         * @param array|string $date Message to format
         * @param array $headers Additional header to append to the request
         * @return ApiResponse JSON representation of the error message
         */
        public static function errorNotFound($data = array(), $headers = array())
        {
            return self::json($data, '404', $headers, $options=JSON_PRETTY_PRINT);
        }

        /**
         *    A generic error message, given when an unexpected condition was encountered and no more specific message is suitable.
         * @param array|string $date Message to format
         * @param array $headers Additional header to append to the request
         * @return ApiResponse JSON representation of the error message
         */
        public static function errorInternal($data = array(), $headers = array())
        {
            return self::json($data, '500', $headers, $options=JSON_PRETTY_PRINT);
        }
    }
}