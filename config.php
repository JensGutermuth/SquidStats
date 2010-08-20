<?
function get_config_from_config_file() {
    $config["db.host"] = "localhost";
    $config["db.username"] = "squidstats";
    $config["db.password"] = "squidstats";
    $config["db.dbname"] = "squidstats";
    $config["log.min_severity"] = 0;
    $config["basepath"] = dirname(__FILE__);
    $config["tpl.template_dir"] = 'tpl';
    return $config;
}
?>
