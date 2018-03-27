<?php
declare(strict_types=1);

namespace App\Controller\Tools;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeploymentController extends Controller
{
    /**
     * @Route("/_tools/deployment", name="tools.deployment", methods={"GET", "POST"})
     *
     * Process deployment using Git.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \InvalidArgumentException
     */
    public function deployment(): Response
    {
        $commands = [
            'echo $PWD',
            'whoami',
            'git reset --hard HEAD',
            'git pull',
            'git status',
            'git submodule sync',
            'git submodule update',
            'git submodule status'
        ];

        // Run the commands for output
        $output = '';

        foreach($commands as $command){
            // Run it
            $tmp = \shell_exec($command);
            // Output
            $output .= \sprintf(
                "<span style=\"color: #6BE234;\">\$</span> <span style=\"color: #729FCF;\">{%s}\n</span>%s\n",
                $command,
                \htmlentities(\trim($tmp))
            );
        }

        return new Response($output);
    }
}
