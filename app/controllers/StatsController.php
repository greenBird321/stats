<?php


namespace MyApp\Controllers;


use MyApp\Models\Logs;
use Phalcon\Exception;
use Phalcon\Mvc\Dispatcher;

class StatsController extends ControllerBase
{

    public function loginAction()
    {
        $app_id = $this->request->get('app_id', 'int', 0);
        $user_id = $this->request->get('user_id', 'int', 0);
        $uuid = $this->request->get('uuid', ['string', 'lower'], '');

        if (empty($app_id) || empty($user_id) || empty($uuid)) {
            $this->response->setJsonContent(['code' => 1, 'msg' => _('missing')], JSON_UNESCAPED_UNICODE)->send();
            exit();
        }

        try {
            $log = [
                'app_id'  => $app_id,
                'zone'    => $this->request->get('zone', ['alphanum', 'trim'], ''),
                'user_id' => $user_id,
                'uuid'    => $uuid,
                'adid'    => $this->request->get('adid', ['string', 'lower'], ''),
                'device'  => $this->request->get('device', 'string', ''),
                'version' => $this->request->get('version', 'string', ''),
                'channel' => $this->request->get('channel', 'string', ''),
                'type'    => $this->request->get('type', 'int', 0), // 1 新增, 默认0
                'ip'      => $this->request->getClientAddress()
            ];
            $logs = new Logs();
            $logs->userLog($log);
            $logs->rollLog($log);
        } catch (Exception $e) {
            // TODO :: error logs
        }

        $this->response->setJsonContent(['code' => 0, 'msg' => _('success')], JSON_UNESCAPED_UNICODE)->send();
        exit();
    }

    /**
     * 安装日志
     */
    public function installAction()
    {
        $app_id = $this->request->get('app_id', 'int', 0);
        $uuid = $this->request->get('uuid', ['string', 'lower'], '');

        if (empty($app_id) || empty($uuid)) {
            $this->response->setJsonContent(['code' => 1, 'msg' => _('missing')], JSON_UNESCAPED_UNICODE)->send();
            exit();
        }

        try {
            $log = [
                'app_id' => $app_id,
                'uuid' => $uuid,
                'adid' => $this->request->get('adid', ['string', 'lower'], ''),
                'device' => $this->request->get('device', 'string', ''),
                'version' => $this->request->get('version', 'string', ''),
                'channel' => $this->request->get('channel', 'string', ''),
                'ip' => $this->request->getClientAddress(),
            ];
            $logs = new Logs();
            $logs->installLog($log);
        } catch (Exception $e) {

        }

        $this->response->setJsonContent(['code' => 0, 'msg' => _('success')], JSON_UNESCAPED_UNICODE)->send();
        exit();
    }

    //进服日志
    public function intoAction()
    {
        $app_id = $this->request->get('app_id', 'int', 0);
        $user_id = $this->request->get('user_id', 'int', 0);
        $uuid = $this->request->get('uuid', ['string', 'lower'], '');

        if (empty($app_id) || empty($user_id) || empty($uuid)) {
            $this->response->setJsonContent(['code' => 1, 'msg' => _('missing')], JSON_UNESCAPED_UNICODE)->send();
            exit();
        }

        try {
            $log = [
                'app_id'  => $app_id,
                'zone'    => $this->request->get('zone', ['alphanum', 'trim'], ''),
                'user_id' => $user_id,
                'uuid'    => $uuid,
                'adid'    => $this->request->get('adid', ['string', 'lower'], ''),
                'device'  => $this->request->get('device', 'string', ''),
                'version' => $this->request->get('version', 'string', ''),
                'channel' => $this->request->get('channel', 'string', ''),
                'ip'      => $this->request->getClientAddress()
            ];
            $logs = new Logs();
            $logs->intoLog($log);
        } catch (Exception $e) {
            // TODO :: error logs
        }

        $this->response->setJsonContent(['code' => 0, 'msg' => _('success')], JSON_UNESCAPED_UNICODE)->send();
        exit();
    }
}