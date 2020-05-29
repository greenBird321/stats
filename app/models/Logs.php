<?php

namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\DI;
use Phalcon\Db;
use Exception;

class Logs extends Model
{

    public function initialize()
    {
        $this->setConnectionService('dbLog');
    }


    /**
     * 账号日志
     * @param array $log
     * @return bool
     */
    public function userLog($log = [])
    {
        $log['create_time'] = date('Y-m-d H:i:s');

        $table = "users_login_" . date('Ym');
        try {
            DI::getDefault()->get('dbLog')->insertAsDict($table, $log);
        } catch (Exception $e) {
            if (!$this->createLogTable($table)) {
                return false;
            }
            DI::getDefault()->get('dbLog')->insertAsDict($table, $log);
        }
        return true;
    }

    /**
     * 游戏安装日志
     * @param array $log
     * @return bool
     */
    public function installLog($log = [])
    {
        $log['create_time'] = date('Y-m-d H:i:s');
        $table = 'install_log';

        try {
            DI::getDefault()->get('dbLog')->insertAsDict($table, $log);
        } catch (Exception $e) {
            if (!$this->createInstallTable($table)) {
                return false;
            }
            DI::getDefault()->get('dbLog')->insertAsDict($table, $log);
        }

        return true;
    }

    /**
     * 进服日志
     * @param array $log
     * @return bool
     */
    public function intoLog($log = [])
    {
        $log['create_time'] = date('Y-m-d H:i:s');

        $table = "users_into_" . $log['app_id'];



        try {
            $sql = "SELECT COUNT(1) num FROM $table WHERE user_id=:user_id AND app_id=:app_id and zone=:zone";
            $bind = array('user_id' => $log['user_id'], 'app_id' => $log['app_id'],'zone' => $log['zone']);
            $query = DI::getDefault()->get('dbLog')->query($sql, $bind);
            $query->setFetchMode(Db::FETCH_ASSOC);
            $num = $query->fetch();
            if(!$num['num'])
            {
                DI::getDefault()->get('dbLog')->insertAsDict($table, $log);
            }
        } catch (Exception $e) {
            if (!$this->createIntoLogTable($table)) {
                return false;
            }
            DI::getDefault()->get('dbLog')->insertAsDict($table, $log);
        }

        return true;
    }

    /**
     * 滚服日志
     * @param array $log
     * @return bool
     */
    public function rollLog($log = [])
    {
        if($log['type'])
        {
            $log['create_time'] = date('Y-m-d H:i:s');
            $table = "user_roll_" . $log['app_id'];
            try {
                $sql = "SELECT COUNT(1) num FROM $table WHERE user_id=:user_id AND app_id=:app_id";
                $bind = array('user_id' => $log['user_id'], 'app_id' => $log['app_id']);
                $query = DI::getDefault()->get('dbLog')->query($sql, $bind);
                $query->setFetchMode(Db::FETCH_ASSOC);
                $num = $query->fetch();
                if($num['num'])
                {
                    $log['type'] = 0;
                }
                DI::getDefault()->get('dbLog')->insertAsDict($table, $log);
            } catch (Exception $e) {
                if (!$this->createRollLogTable($table)) {
                    return false;
                }
                DI::getDefault()->get('dbLog')->insertAsDict($table, $log);
            }
        }
        return true;
    }

    /**
     * 创建日志表
     * @param string $tableName
     * @return mixed
     */
    private function createLogTable($tableName = '')
    {
        $sql = <<<END
CREATE TABLE `{$tableName}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(11) DEFAULT '0',
  `zone` varchar(16) DEFAULT '',
  `user_id` bigint(20) DEFAULT '0',
  `uuid` varchar(36) DEFAULT '',
  `adid` varchar(36) DEFAULT '',
  `device` varchar(32) DEFAULT '',
  `version` varchar(32) DEFAULT '',
  `channel` varchar(32) DEFAULT '',
  `ip` varchar(46) DEFAULT '',
  `type` tinyint(3) DEFAULT '0',
  `create_time` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
END;
        try {
            DI::getDefault()->get('dbLog')->execute($sql);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * 创建安装日志表
     * @return bool
     */
    private function createInstallTable($tableName)
    {
        $sql = <<<END
CREATE TABLE `{$tableName}`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(11) DEFAULT '0',
  `uuid` varchar(36) DEFAULT '',
  `adid` varchar(36) DEFAULT '',
  `device` varchar(32) DEFAULT '',
  `version` varchar(32) DEFAULT '',
  `channel` varchar(32) DEFAULT '',
  `ip` varchar(46) DEFAULT '',
  `create_time` timestamp NULL DEFAULT '0000-00-00 00:00:00',
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
END;

        try {
            DI::getDefault()->get('dbLog')->execute($sql);
        } catch (Exception $e) {
            return false;
        }

        return true;
    }

    /**
     * 创建进服日志表
     * @param string $tableName
     * @return mixed
     */
    private function createIntoLogTable($tableName = '')
    {
        $sql = <<<END
CREATE TABLE `{$tableName}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(11) DEFAULT '0',
  `zone` varchar(16) DEFAULT '',
  `user_id` bigint(20) DEFAULT '0',
  `uuid` varchar(36) DEFAULT '',
  `adid` varchar(36) DEFAULT '',
  `device` varchar(32) DEFAULT '',
  `version` varchar(32) DEFAULT '',
  `channel` varchar(32) DEFAULT '',
  `ip` varchar(46) DEFAULT '',
  `create_time` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
END;
        try {
            DI::getDefault()->get('dbLog')->execute($sql);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * 创建滚服日志表
     * @param string $tableName
     * @return mixed
     */
    private function createRollLogTable($tableName = '')
    {
        $sql = <<<END
CREATE TABLE `{$tableName}` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` int(11) DEFAULT '0',
  `zone` varchar(16) DEFAULT '',
  `user_id` bigint(20) DEFAULT '0',
  `uuid` varchar(36) DEFAULT '',
  `adid` varchar(36) DEFAULT '',
  `device` varchar(32) DEFAULT '',
  `version` varchar(32) DEFAULT '',
  `channel` varchar(32) DEFAULT '',
  `type` tinyint(3) DEFAULT '0',
  `ip` varchar(46) DEFAULT '',
  `create_time` timestamp NULL DEFAULT '0000-00-00 00:00:00',
  UNIQUE KEY (`app_id`,`user_id`,`zone`),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
END;
        try {
            DI::getDefault()->get('dbLog')->execute($sql);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
}
