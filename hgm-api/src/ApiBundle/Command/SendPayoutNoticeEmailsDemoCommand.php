<?php

namespace ApiBundle\Command;

class SendPayoutNoticeEmailsDemoCommand extends \Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand
{
    public function configure()
    {
        $this->setName('payout:notify');
    }

    public function execute(
        \Symfony\Component\Console\Input\InputInterface $input,
        \Symfony\Component\Console\Output\OutputInterface $output
    )
    {
        $emails = array(
//            'antal.andrei@icloud.com',
//            'andreas.fruth@gmail.com',
//            'valentin.tureac@gmail.com',

            'ionutdanieldobos6220@gmail.com',
            'zaboco@gmail.com',
            'andrei.s.tudor@gmail.com',
        );
        /** @var \ApiBundle\Service\EmailService $emailService */
        $emailService = $this->getContainer()->get('email_service');

        var_dump($emailService->sendPayoutNotice($emails));
    }

}