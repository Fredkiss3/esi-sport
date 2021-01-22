<?php

namespace App\DataFixtures;

use App\Entity\Security\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserFixtures constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        // Create The Admin
        $user = (new User())
            ->setFirstName("Fredhel")
            ->setLastName("KISSIE")
            ->setEmail("fredkiss3@esi-sport.club");

        $user->setPassword($this->encoder->encodePassword($user, "admin"));
        $manager->persist($user);

        // Create Ten More Users
//        for ($i = 0; $i < 10; $i++) {
//            $user = (new User())
//                ->setEmail("user$i@esi-sport.club")
//                ->setPassword($this->encoder->encodePassword($user, "user$i"));
//            $manager->persist($user);
//        }

        $manager->flush();
    }
}
