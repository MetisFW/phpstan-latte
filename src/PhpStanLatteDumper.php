<?php

namespace Metis\Dev;

use Latte\Engine;
use Latte\Macros\BlockMacros;
use Latte\Macros\CoreMacros;
use Nette\Bridges\ApplicationLatte\UIMacros;
use Nette\Bridges\FormsLatte\FormMacros;
use Nette\Utils\FileSystem;
use Nette\Utils\Finder;
use SplFileInfo;

class PhpStanLatteDumper {

  /** @var Engine */
  protected $latte;

  public function __construct(Engine $latte = null) {
    try {
      $this->latte = $latte ?? self::basicEngine();
      $this->latte->setAutoRefresh(true);
    } catch(\Throwable $e) {
      echo $e->getMessage()."\n";
      echo $e->getTraceAsString();
    }
  }

  public static function basicEngine() {
    $engine = new Engine();
    $compiler = $engine->getCompiler();
    CoreMacros::install($compiler);
    FormMacros::install($compiler);
    BlockMacros::install($compiler);
    UIMacros::install($compiler);
    $compiler->addMacro('cache', new \Nette\Bridges\CacheLatte\CacheMacro());
    return $engine;
  }

  public function dumpLatte($from, $to) {
    $from = realpath($from);
    try {
      Filesystem::delete($to);
      Filesystem::createDir($to);
      /** @var SplFileInfo $file */
      foreach(Finder::find("*.latte")->from($from) as $file) {
        $outputFile = $to . substr($file->getPathname(), strlen($from)) . ".php";
        $code = $this->latte->compile($file->getPathname());
        FileSystem::write($outputFile, $code);
      }
    } catch(\Throwable $e) {
      echo $e->getMessage()."\n";
      echo $e->getTraceAsString();
    }
  }

}