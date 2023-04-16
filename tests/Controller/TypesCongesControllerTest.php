<?php

namespace App\Test\Controller;

use App\Entity\TypesConges;
use App\Repository\TypesCongesRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TypesCongesControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private TypesCongesRepository $repository;
    private string $path = '/types/conges/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(TypesConges::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('TypesConge index');

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
            'types_conge[label]' => 'Testing',
            'types_conge[paye]' => 'Testing',
            'types_conge[limite]' => 'Testing',
            'types_conge[unite]' => 'Testing',
        ]);

        self::assertResponseRedirects('/types/conges/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new TypesConges();
        $fixture->setLabel('My Title');
        $fixture->setPaye('My Title');
        $fixture->setLimite('My Title');
        $fixture->setUnite('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('TypesConge');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new TypesConges();
        $fixture->setLabel('My Title');
        $fixture->setPaye('My Title');
        $fixture->setLimite('My Title');
        $fixture->setUnite('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'types_conge[label]' => 'Something New',
            'types_conge[paye]' => 'Something New',
            'types_conge[limite]' => 'Something New',
            'types_conge[unite]' => 'Something New',
        ]);

        self::assertResponseRedirects('/types/conges/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getLabel());
        self::assertSame('Something New', $fixture[0]->getPaye());
        self::assertSame('Something New', $fixture[0]->getLimite());
        self::assertSame('Something New', $fixture[0]->getUnite());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new TypesConges();
        $fixture->setLabel('My Title');
        $fixture->setPaye('My Title');
        $fixture->setLimite('My Title');
        $fixture->setUnite('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/types/conges/');
    }
}
