<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;

class Supporter extends Controller
{
    public $authors = [
        'york' => 0,
        'fisher' => 0,
        'jason' => 0,
        '白白' => 0,
        'ashley' => 0,
        'momoka' => 0,
        'christine' => 0
    ];

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $command = 'git --git-dir=../.git shortlog -sn --all --no-merges';
        
        $process = new Process(explode(' ', $command));
        $process->run();
        
        $ret = explode(' ', $process->getOutput());
        foreach($ret as $v){
            if ($v) {
                $author = explode("\t", trim($v));
                if (isset($this->authors[strtolower($author[1])])) {
                    $this->authors[strtolower($author[1])] = (int) $author[0];
                }
            }
        }

        $data['authors'] = $this->authors;
        
        return view('supporter', $data);
    }
}
