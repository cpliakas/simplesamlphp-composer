<?php

exec('svn ls http://simplesamlphp.googlecode.com/svn/tags', $output, $retvar);
if (!$retvar) {

  $versions = array();
  foreach ($output as $tag) {

    $version = rtrim(str_replace('-', '', substr($tag, 14)), '/');
    $url = 'https://simplesamlphp.googlecode.com/files/' . rtrim($tag, '/') . '.tar.gz';

    $versions[$version] = array(
      'name' => 'simplesamlphp/simplesamlphp',
      'version' => $version,
      'dist' => array(
        'url' => $url,
        'type' => 'tar',
      ),
    );
  }

  $packages = array(
    'packages' => array(
      'simplesamlphp/simplesamlphp' => $versions,
    ),
  );

  $json_options = JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT;
  if (defined('JSON_PRETTY_PRINT')) {
    $json_options = $json_options | JSON_PRETTY_PRINT;
  }
  if (defined('JSON_UNESCAPED_SLASHES')) {
    $json_options = $json_options | JSON_UNESCAPED_SLASHES;
  }

  $json = json_encode($packages, $json_options);
  file_put_contents(__DIR__ . '/packages.json', $json);
}
else {
  exit($retvar);
}
