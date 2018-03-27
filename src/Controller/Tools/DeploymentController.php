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
        $output = '<h1>Deployment tools using Git</h1><table><tr><th>Command</th><th>Output</th></tr>';

        foreach($commands as $command){
            // Run it
            $tmp = \shell_exec($command);
            // Output
            $output .= \sprintf(
                "<tr><td><span style=\"color: #6BE234;\">$</span> <span style=\"color: #729FCF;\">{%s}\n</span></td><td>%s</td></tr>",
                $command,
                \htmlentities(\trim($tmp ?? 'no output'))
            );
        }

        $output .= '</table>';

        return new Response($output);
    }
}
