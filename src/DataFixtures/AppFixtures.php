<?php

namespace App\DataFixtures;

use App\Entity\BlogPost;
use App\Entity\Comment;
use App\Entity\TipoDocumento;
use App\Entity\User;
use App\Security\TokenGenerator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    
    /**
     * @var \Faker\Factory
     */
    private $faker;
    
    private const USERS = [['username' => 'admin', 'email' => 'admin@s4jwt.com', 'name' => 'Administrador', 'password' => 'secret123#', 'roles' => [User::ROLE_SUPERADMIN], 'enabled' => true], ['username' => 'abrusut', 'email' => 'abrusutti@s4jwt.com', 'name' => 'Andres Brusutti', 'password' => 'secret123#', 'roles' => [User::ROLE_ADMIN], 'enabled' => true], ['username' => 'user', 'email' => 'user@s4jwt.com', 'name' => 'User', 'password' => 'secret123#', 'roles' => [User::ROLE_USER], 'enabled' => true], ['username' => 'viewer', 'email' => 'viewer@s4jwt.com', 'name' => 'Viewer', 'password' => 'secret123#', 'roles' => [User::ROLE_VIEWER], 'enabled' => true]];
    /**
     * @var TokenGenerator
     */
    private $tokenGenerator;
    
    public function __construct(UserPasswordEncoderInterface $passwordEncoder, TokenGenerator $tokenGenerator)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = \Faker\Factory::create();
        
        $this->tokenGenerator = $tokenGenerator;
    }
    
    /**
     * Load data fixtures with the passed EntityManager
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadTipoDocumento($manager);
        
    }
    
    
    public function loadTipoDocumento(ObjectManager $manager)
    {
        $tipoDNI = new TipoDocumento();
        $tipoDNI->setTipo('DNI');
        $manager->persist($tipoDNI);
        
        $tipoDNI = new TipoDocumento();
        $tipoDNI->setTipo('LC');
        $manager->persist($tipoDNI);
        
        $tipoDNI = new TipoDocumento();
        $tipoDNI->setTipo('LE');
        $manager->persist($tipoDNI);
        
        $manager->flush();
    }
    
    public function loadUsers(ObjectManager $manager)
    {
        foreach (self::USERS as $userFixture) {
            $user = new User();
            $user->setUsername($userFixture['username']);
            $user->setEmail($userFixture['email']);
            $user->setFullName($userFixture['name']);
            
            $user->setPassword($this->passwordEncoder->encodePassword($user, $userFixture['password']));
            $user->setRoles($userFixture['roles']);
            $user->setEnabled($userFixture['enabled']);
            
            if (!$userFixture['enabled']) {
                $user->setConfirmationToken($this->tokenGenerator->getRandomSecureToken());
            }
            
            $this->addReference('user_' . $userFixture['username'], $user);
            
            $manager->persist($user);
        }
        
        $manager->flush();
    }
    
    
}
