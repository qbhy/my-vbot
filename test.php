<?php

class Pipe
{
    /**
     * 程序路径
     */
    public $path;

    private $handle;

    public $descriptorspec = [
        ['pipe', 'r'],
        ['pipe', 'w']
    ];

    /**
     * 数据之间的分隔符
     */
    protected $delimiter = "\n";


    function __construct($path)
    {
        $this->handle = proc_open($path, $this->descriptorspec, $pipes);
        $this->path = $path;
        $this->pipes = $pipes;
    }

    public function exec($params)
    {
        $params = is_array($params) ? json_encode($params) : $params;
        fwrite($this->pipes['0'], $params . $this->delimiter);
        return fgets($this->pipes[1]);
    }

    public function close()
    {
        pclose($this->handle);
    }
}


$p = new Pipe(__DIR__ . '/../../../go/src/helloBee/test');

$result =  $p->exec('a');

echo $result;

