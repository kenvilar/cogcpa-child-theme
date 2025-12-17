<?php

$dir = __DIR__;
if (! is_dir($dir)) return;

$files = [];
$iterator = new RecursiveIteratorIterator(
  new RecursiveDirectoryIterator($dir, FilesystemIterator::SKIP_DOTS)
);

foreach ($iterator as $fileInfo) {
  if (! $fileInfo->isFile()) continue;
  if (strtolower($fileInfo->getExtension()) !== 'php') continue;

  $path = $fileInfo->getPathname();

  // don't require index.php itself
  if (realpath($path) === __FILE__) continue;

  $files[] = $path;
}

natcasesort($files);

foreach ($files as $file) {
  require_once $file;
}