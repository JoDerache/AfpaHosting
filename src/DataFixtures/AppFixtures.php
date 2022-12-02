<?php

namespace App\DataFixtures;

use App\Entity\ConsigneHebergement;
use Faker\Factory;
use Faker\Generator;
use App\Entity\Personne;
use App\Entity\Financeur;
use App\Entity\Formations;
use App\Entity\TypeTravaux;
use App\Entity\TypePaiement;
use App\Entity\Participation;
use App\Entity\TypeEtatLieux;
use App\Entity\PersonneAContacter;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;


class AppFixtures extends Fixture
{
    /**
     * @var Generator
     */
    private Generator $faker ;

    public function __construct()
    {
        $this->faker =Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $listeTitreFormation = ['DWW', 'CDA', 'Nursery', 'Automobile','Secrétaire comptable', 'Conseiller relation client à distance'];
        $listFormations=[];
        for ($i = 0; $i < 10; $i++) {
            $Formation = new Formations();
            $Formation->setNomFormation($listeTitreFormation[mt_rand(0, count($listeTitreFormation) - 1)])
            ->setNumeroOffre($this->faker->randomNumber(8, true));

            $listFormations[] = $Formation;
            $manager->persist($Formation);
        }

        $listeNomFinanceur =['Région Hdf', 'Pole Emploi','MdM', "autofinancement"];
        $listFinanceurs=[];
        foreach ($listeNomFinanceur as $LFi) {
            $Financeur = new Financeur();
            $Financeur->setNom($LFi);

            $listFinanceurs[] = $Financeur;
            $manager->persist($Financeur);
        }

        $personnes =[];
        for ($i=1; $i < 50; $i++) { 
            $personne = new Personne();
            $personne->setNom($this->faker->lastName())
                ->setPrenom($this->faker->firstName())
                ->setAdressePostale($this->faker->address())
                ->setTelephone($this->faker->phonenumber())
                ->setMail($this->faker->safeEmail())
                ->setDateNaissance($this->faker->dateTimeBetween('1957-01-01', '2004-12-31'))
                ->setBadge($this->faker->randomNumber(5, true))
                ->setNumeroBeneficiaire($this->faker->randomNumber(8, true))
                ->setIsBlacklisted(False)
                ->setLieuNaissance($this->faker->city());
            $personnes[]=$personne;
            $manager->persist($personne);
        }
 
        for ($i=1; $i < 50; $i++) { 
            $personneContact = new PersonneAContacter();
            $personneContact->setNom($this->faker->lastName())
                ->setPrenom($this->faker->firstName())
                ->setTelephone((int)$this->faker->phonenumber())
                ->setIdPersonne($personnes[mt_rand(0, count($personnes) - 1)]);

            $manager->persist($personneContact);
        }
        
        
        foreach ($personnes as $P) {
            $participation = new Participation();
            $participation->setDateEntree($this->faker->dateTimeBetween('2022-01-22', '2022-11-22'))
                ->setDateSortie($this->faker->dateTimeBetween('2022-11-22', '2023-06-22'))
                ->setIdFinanceur($listFinanceurs[mt_rand(0, count($listFinanceurs) - 1)])
                ->setIdFormation($listFormations[mt_rand(0, count($listFormations) - 1)])
                ->setIdPersonne($P);
            $manager->persist($participation);
        }

        $Listepayment=["espece", "cheque"];
        foreach($Listepayment as $Nompayment ){
            $payment = new TypePaiement();
            $payment -> setNomPaiement($Nompayment);
        }

        $nomTypeTravaux =["Répartion", "Peinture", "Refection totale"];
        foreach($nomTypeTravaux as $nameT){
            $traveaux = new TypeTravaux();
            $traveaux-> setNomTravaux($nameT);
            $manager->persist($traveaux);
        }

        $nomEtatDeLieu=["entree", "sortie"];
        foreach($nomEtatDeLieu as $nameEL){
            $etatDesLieux = new TypeEtatLieux();
            $etatDesLieux-> setNomEtatLieux($nameEL);
            $manager->persist($etatDesLieux);
        }


        $titreConsignes=["Consigne de Sécurité", "Consigne Cusine", "Consignes Laverie", "Consigne Lingerie", "Consigne Covid", "Bandeau"];
        foreach($titreConsignes as $TC){
            $consigne = new ConsigneHebergement;
            $consigne -> setNom($TC)
                -> setTexte($this->faker->text());
            $manager->persist($consigne);
        }
        

        $manager->flush();
    }
}
