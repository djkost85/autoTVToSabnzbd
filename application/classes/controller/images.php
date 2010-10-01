<?php defined('SYSPATH') or die('No direct script access.');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

/**
 * Description of image
 *
 * @author Morre95
 */
class Controller_Images extends Controller {

    public function action_show($dir, $name, $size = null) {
        $image = Image::factory("images/$dir/$name");
        if (!is_null($size)) {
            $image->resize(NULL, $size, Image::INVERSE);
//            $image->reflection(50, 100, TRUE);
        }

        $this->request->headers['Content-Type'] = $image->mime;

        $content = $image->render(null, 80);
        $this->request->headers['Content-length'] = strlen($content);

        
        $this->request->send_headers();

        echo $content;
        exit;
    }

    public function action_thetvdb($size) {
        if (!isset($_GET['image'])) {
            return;
        }
        $file = $_GET['image'];

        $this->showImage($file, true);
    }

    public function action_ordImage() {
        $file = 'images/'.$this->request->param('file');

        if ( ! is_file($file)) {
            throw new Kohana_Exception('Image does not exist');
        }

        $ext = pathinfo($file, PATHINFO_EXTENSION);
        $this->request->headers['Content-Type'] = File::mime_by_ext($ext);

        $this->request->headers['Content-length'] = filesize($file);

        $this->showImage($file);
    }

    protected function showImage($file, $remote = false) {
        if ($remote) {
            $this->request->headers['Content-Type'] = File::mime($file);
        } else {
            $image = Image::factory($file);
            $this->request->headers['Content-Type'] = $image->mime;
        }

        // Send the set headers to the browser
        $this->request->send_headers();

        // Send the file
        $img = @ fopen($file, 'rb');
        if ($img) {
            fpassthru($img);
            exit;
        }
    }
}
?>
