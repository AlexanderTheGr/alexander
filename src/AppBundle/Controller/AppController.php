<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Response;

class AppController extends Controller {
    /**
    * @Route("/app/install")
    */
    public function installAction(Request $request) {
        
        // replace this example code with whatever you need
        set_time_limit(100000);
        //ini_set('memory_limit', '128M');

        
        $kernel = $this->get('kernel');
        $application = new Application($kernel);
        $application->setAutoExit(false);

        //$options = array('command' => 'doctrine:schema:update', "--force" => true);
        $input = new ArrayInput(array(
            'command' => 'doctrine:schema:update',
            "--force" => true
        ));
        
        // You can use NullOutput() if you don't need the output
        $output = new BufferedOutput();
        $application->run($input, $output);

        // return the output, don't use if you used NullOutput()
        $content = $output->fetch();
        return new Response($content); 
    }      

}
