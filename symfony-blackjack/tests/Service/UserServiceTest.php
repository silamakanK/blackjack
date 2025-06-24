<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use App\Entity\User;

class UserServiceTest extends WebTestCase
{
    public function testPasswordIsHashedOnRegistration(): void
    {
        $client = static::createClient();

        $client->jsonRequest(
            'POST',
            '/register',
            [
                'email' => 'testuser@example.com',
                'password' => 'MySecretPassword123'
            ]
        );

        $this->assertResponseIsSuccessful();

        // Récupère l'utilisateur depuis la base de données
        $user = self::getContainer()->get('doctrine')->getRepository(User::class)
            ->findOneBy(['email' => 'testuser@example.com']);

        $this->assertNotNull($user, 'L\'utilisateur doit être créé.');
        $this->assertNotEquals('MySecretPassword123', $user->getPassword(), 'Le mot de passe ne doit pas être stocké en clair.');
        $this->assertStringStartsWith('$', $user->getPassword(), 'Le mot de passe doit être hashé.');
    }
}