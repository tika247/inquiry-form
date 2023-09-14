<?php

declare(strict_types=1);

namespace model;

/**
 * 共通使用の値を返す
 */
class GetConfig
{
    public function __construct()
    {
        $this->repoRoot = dirname($_SERVER["DOCUMENT_ROOT"]);
    }
    /**
     * リポジトリのパスを返す
     */
    public function getRepoRoot()
    {
        return $this->repoRoot;
    }
    /**
     * common.iniを返す
     */
    public function getCommonIni()
    {
        return parse_ini_file($this->repoRoot . "/config/common.ini", true);
    }
    /**
     * csv.iniを返す
     */
    public function getCsvIni()
    {
        return parse_ini_file($this->repoRoot . "/config/csv.ini", true);
    }
    /**
     * mail.iniを返す
     */
    public function getMailIni()
    {
        return parse_ini_file($this->repoRoot . "/config/mail.ini");
    }
}
