<?php

namespace App\DataFixtures;

use App\Entity\Collage;
use App\Entity\Review;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $review = new Review();
        $review->setRating(5);
        $review->setBody("Nic moc uprimne");
        $review->setCreatedAt(new DateTimeImmutable("now"));
        $manager->persist($review);

        $collage = new Collage();
        $collage->setName('FEI STU');
        $collage->setSlug('fei-stu');
        $collage->setDescription(
            '
            Poslaním Fakulty elektrotechniky a informatiky, jednej z najstarších
            technických fakúlt na Slovensku s bohatou vedeckou a výskumnou činnosťou, 
            je poskytovanie kvalitného vzdelávania na báze slobodného vedeckého bádania
            a tvorivej výskumnej práce.'
        );
        $collage->setFoundedAt(new DateTimeImmutable("now"));
        $collage->addReview($review);
        $manager->persist($collage);

        $collage = new Collage();
        $collage->setName('FIIT STU');
        $collage->setSlug('fii-stu');
        $collage->setDescription(
            '
           Fakulta informatiky a informačných technológií STU v Bratislave
            Na Slovensku v súčasnosti chýba až 20 000 informatikov, 
            v Európe dokonca až 900 000! Zaplň medzeru na trhu.'
        );
        $collage->setFoundedAt(new DateTimeImmutable("now"));
        $manager->persist($collage);

        $collage = new Collage();
        $collage->setName('MTF STU');
        $collage->setSlug('mtf-stu');
        $collage->setDescription(
            '
                Materiálovotechnologická fakulta STU v Bratislave so sídlom v Trnave chce byť, v 
                kontexte s víziou STU, výskumne orientovanou, celoslovensky a medzinárodne uznávanou a priemyslom akceptovanou fakultou. 
                Chce poskytovať špičkové, medzinárodne porovnateľné vzdelávanie a rozvíjať moderné trendy vo výskume a priemyselnej výrobe.'
        );
        $collage->setFoundedAt(new DateTimeImmutable("now"));
        $manager->persist($collage);

        $manager->flush();
    }
}
