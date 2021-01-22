<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BlogFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
    }
//    public function load(ObjectManager $manager)
//    {
//        for ($i = 0; $i < 10; $i++) {
//            $info = (new InfoFlash())
//                ->setContent(Lorem::text());
//            if($i % 2 == 0)
//                $info->setPublishedAt(DateTime::dateTime());
//            $manager->persist($info);
//        }
//
//        $manager->flush();
//
//        for ($i = 0; $i < 20; $i++) {
//            $info = (new Article())
//                ->setContent(Lorem::text())
//                ->setTitle(Lorem::sentence());
//            if($i % 2 == 0)
//                $info->setPublishedAt(DateTime::dateTime());
//            $manager->persist($info);
//        }
//
//        $manager->flush();
//    }
}
