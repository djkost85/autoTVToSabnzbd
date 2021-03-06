<?php defined('SYSPATH') or die('No direct script access.');
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of queue
 *
 * @author morre95
 */
class Controller_Queue extends Controller_Page {

    public function action_index() {
        try {
            $sab = new Sabnzbd_Queue(Kohana::config('default.Sabnzbd'));
        } catch (RuntimeException $e) {
            Kohana::exception_handler($e);
            return;
        }

        $queue = $sab->getQueue();

        $this->template->title = 'SABnzbd Queue';
        $xhtml = View::factory('queue/index');

        $this->template->scripts['sabQueueScript'] = 'js/sabQueue.js';
        $this->template->styles['css/sabQueue.css'] = 'screen';

        $xhtml->set('queue', $queue->slots)
                ->set('pause', $sab->getUrl('pause'))
                ->set('resume', $sab->getUrl('resume'))
                ->set('restart', ($queue->restart_req) ? $sab->getUrl('restart') : false)
                ->set('shutdown', $sab->getUrl('shutdown'))
                ->set('pauseNum', $queue->paused)
                ->set('deleteAll', $sab->getDelete('all'))
                ->set('version', $queue->version)
                ->set('tempDisk', $queue->diskspace1 . ' GB/' . $queue->diskspacetotal1 . ' GB')
                ->set('compDisk', $queue->diskspace2 . ' GB/' . $queue->diskspacetotal2 . ' GB')
                ->set('warnings', false)
                ->set('speed', $queue->speed)
                ->set('timeleft', $queue->timeleft)
                ->set('sizeleft', $queue->sizeleft . '/' . $queue->size)
                ->set('eta', $queue->eta);

        $xhtml->set('totalPercent', 0);

        if ((int)$queue->mb > 0)
           $xhtml->set('totalPercent', round(((int)$queue->mbleft / (int)$queue->mb) * 100));

        if (isset($queue->have_warnings)) {
            $xhtml->set('warnings', $queue->have_warnings)
                    ->set('lastWarning', $queue->last_warning);
        }

        $this->template->content = $xhtml;
    }
    
    public function action_ajax_getProcent() {
        $sab = new Sabnzbd_Queue(Kohana::config('default.Sabnzbd'));
        $queue = $sab->getQueue(false);

        $this->auto_render = false;

        $totalPercent = 0;
        if ((int)$queue->mbleft > 0 && (int)$queue->mb > 0) {
            $totalPercent = round(((int)$queue->mbleft / (int)$queue->mb) * 100);
        }

        $this->request->headers['Content-Type'] = 'text/json';
        $this->request->response = json_encode(
                array(
                    'total_percent' => $totalPercent,
                    'total_text' => $queue->sizeleft . '/' . $queue->size,
                    'speed' => $queue->speed,
                    'temp_disk' => $queue->diskspace1 . ' GB/' . $queue->diskspacetotal1 . ' GB',
                    'comp_disk' => $queue->diskspace2 . ' GB/' . $queue->diskspacetotal2 . ' GB',
                    'time_left' => $queue->timeleft,
                    'eta' => $queue->eta
                    ));
        
    }

}


?>
