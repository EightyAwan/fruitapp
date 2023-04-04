<?php

namespace App\Command;

use App\Entity\Fruit;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class FetchFruitsCommand extends Command
{
    protected static $defaultName = 'fruits:fetch';
    private $httpClient;
    private $entityManager;
    private $mailer;

    public function __construct(HttpClientInterface $httpClient, EntityManagerInterface $entityManager, MailerInterface $mailer)
    {
        parent::__construct();

        $this->httpClient = $httpClient;
        $this->entityManager = $entityManager;
        $this->mailer = $mailer;
    }

    protected function configure()
    {
        $this->setDescription('Fetches all fruits from https://fruityvice.com/api/fruit/all and saves them into local DB table fruits.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this->httpClient->request('GET', 'https://fruityvice.com/api/fruit/all');

        $fruits = json_decode($response->getContent(), true);

        foreach ($fruits as $fruitData) { 

            $fruit = new Fruit();
            $fruit->setName($fruitData['name']);
            $fruit->setGenus($fruitData['genus']);
            $fruit->setFamily($fruitData['family']);
            $fruit->setOrder($fruitData['order']); 
            $fruit->setCarbohydrates($fruitData['nutritions']['carbohydrates']); 
            $fruit->setProtein($fruitData['nutritions']['protein']); 
            $fruit->setFat($fruitData['nutritions']['fat']); 
            $fruit->setCalories($fruitData['nutritions']['calories']); 
            $fruit->setSugar($fruitData['nutritions']['sugar']); 

            $this->entityManager->persist($fruit);
        }

        $this->entityManager->flush();

        $output->writeln('Fruits saved successfully!');

        $email = (new Email())
        ->from('admin@painmap.com')
        ->to('arsalaniqbal1997@gmail.com')
        ->subject('Fruits Fetched.')
        ->text('This is to notify that you command has been executed successfully.');

        $this->mailer->send($email);

        $output->writeln('Email sent!');

        return Command::SUCCESS;
    }
}