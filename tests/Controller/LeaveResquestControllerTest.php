<?php

namespace App\Test\Controller;

use App\Entity\LeaveResquest;
use App\Repository\LeaveResquestRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LeaveResquestControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private LeaveResquestRepository $repository;
    private string $path = '/leave/resquest/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(LeaveResquest::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('LeaveResquest index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'leave_resquest[StartDate]' => 'Testing',
            'leave_resquest[EndDate]' => 'Testing',
            'leave_resquest[typeConge]' => 'Testing',
            'leave_resquest[Reason]' => 'Testing',
            'leave_resquest[FirstName]' => 'Testing',
            'leave_resquest[LastName]' => 'Testing',
        ]);

        self::assertResponseRedirects('/leave/resquest/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new LeaveResquest();
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setTypeConge('My Title');
        $fixture->setReason('My Title');
        $fixture->setFirstName('My Title');
        $fixture->setLastName('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('LeaveResquest');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new LeaveResquest();
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setTypeConge('My Title');
        $fixture->setReason('My Title');
        $fixture->setFirstName('My Title');
        $fixture->setLastName('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'leave_resquest[StartDate]' => 'Something New',
            'leave_resquest[EndDate]' => 'Something New',
            'leave_resquest[typeConge]' => 'Something New',
            'leave_resquest[Reason]' => 'Something New',
            'leave_resquest[FirstName]' => 'Something New',
            'leave_resquest[LastName]' => 'Something New',
        ]);

        self::assertResponseRedirects('/leave/resquest/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getStartDate());
        self::assertSame('Something New', $fixture[0]->getEndDate());
        self::assertSame('Something New', $fixture[0]->getTypeConge());
        self::assertSame('Something New', $fixture[0]->getReason());
        self::assertSame('Something New', $fixture[0]->getFirstName());
        self::assertSame('Something New', $fixture[0]->getLastName());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new LeaveResquest();
        $fixture->setStartDate('My Title');
        $fixture->setEndDate('My Title');
        $fixture->setTypeConge('My Title');
        $fixture->setReason('My Title');
        $fixture->setFirstName('My Title');
        $fixture->setLastName('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/leave/resquest/');
    }
}
