<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';
 
use Illuminate\Support\Collection;
use Carbon\Carbon;

echo "\nQuestion 1:\n";

use App\Hello;

$sayHi = new Hello();

dump($sayHi->hello("Orb")); // "Hello Orb"
dump($sayHi->hello("Horse")); // "Hello Horse"

echo "\nQuestion 2\n";

use App\Person;

$person1 = new Person("Lynne",  "Ramsay");
$person2 = new Person("Wes", "Anderson");

dump($person1->sayHelloTo($person2)); // string(9) "Hello Wes Anderson"
dump($person2->sayHelloTo($person1)); // string(11) "Hello Lynne Ramsay"

echo "\nQuestion 3:\n";

use App\Stuff\Things\Potato;

$potato = new Potato();
$potato->water()->water();

dump($potato->hasGrown()); // false

$potato->water()->water();
dump($potato->hasGrown()); // false

$potato->water();
dump($potato->hasGrown()); // true

$potato->water()->water();
dump($potato->hasGrown()); // true

echo "\nQuestion 4:\n";

use App\Library\Book;

$book = new Book("Zero: The Biography of a Dangerous Idea", 256);

// read 12 pages
$book->read(12);
dump($book->currentPage()); // 13 - start on page 1

// read another 25 pages
$book->read(250);
dump($book->currentPage()); // 38

echo "\nQuestion 5:\n";

use App\Library\Shelf;

$shelf = new Shelf();
$shelf->addBook($book);
$shelf->addBook(new Book("The Catcher in the Rye", 277));
$shelf->addBook(new Book("Stamped from the Beginning", 582));

dump($shelf->titles()); // array:3 [ 0 => "Zero: The Biography of a Dangerous Idea" 1 => "The Catcher in the Rye" 2 => "Stamped from the Beginning" ]

echo "\nQuestion 6:\n";

use App\Library\Library;

$badLibrary = new Library();
$badLibrary->addShelf($shelf);

$otherShelf = new Shelf();
$otherShelf->addBook(new Book("The Power Broker", 1336));
$otherShelf->addBook(new Book("Delusions of Gender", 338));

$badLibrary->addShelf($otherShelf);

dump($badLibrary->titles()); // array:5 [ 0 => "Zero: The Biography of a Dangerous Idea" 1 => "The Catcher in the Rye" 2 => "Stamped from the Beginning" 3 => "The Power Broker" 4 => "Delusions of Gender" ]

echo "\nTricksy Question 1\n";

use App\People\Person as Peep;

$alfred = new Peep("Alfred", "1967-04-03");
$jasmine = new Peep("Jasmine", "1954-12-28");
$walker = new Peep("Walker", "1994-01-12");

dump(Peep::getAges([$alfred, $jasmine, $walker])); // [52, 65, 15] (or there abouts)

echo "\nTricksy Question 2a\n";
// use the factory to create a Faker\Generator instance
$faker = Faker\Factory::create();

// generate data by accessing properties
dump($faker->name);
  // E.g. 'Lucy Cechtelar';

$person1 = new Peep($faker->name, $faker->date);
$person2 = new Peep($faker->name, $faker->date);
$person3 = new Peep($faker->name, $faker->date);

// dump($person1,
//     $person2,
//     $person3);

dump(Peep::getAges([$person1, $person2, $person3])); // random array

echo "\nTricksy Question 2b\n";
// use the factory to create a Faker\Generator instance
// $faker = Faker\Factory::create();
$faker->seed(1234);

// generate data by accessing properties
dump($faker->name);
  // "Miss Lorna Dibbert" ;

$person1 = new Peep($faker->name, $faker->date);
$person2 = new Peep($faker->name, $faker->date);
$person3 = new Peep($faker->name, $faker->date);

// dump($person1,
//     $person2,
//     $person3);

dump(Peep::getAges([$person1, $person2, $person3])); // random array

function validEmail(string $str) : bool {
  $str = preg_replace("/(^\s)|(\s$)/", "", $str); // remove beginning and ending spaces
  return filter_var($str, FILTER_VALIDATE_EMAIL) === $str; // validate email
}

var_dump(validEmail(" blahf   ")); // bool(false)
var_dump(validEmail(" blah@f")); // bool(false)
var_dump(validEmail("blah@ fish.horse")); // bool(false)
var_dump(validEmail(" blah@fish.horse")); // bool(true)
var_dump(validEmail("blah@fish.horse ")); // bool(true)
var_dump(validEmail(" blah@fish.horse ")); // bool(true)

for ($i = 1; $i < 100; $i += 1) { 
  var_dump(validEmail($faker->email));
}


echo "\nUber-Tricksy Question 1\n";

use App\Data\Post;

$post = new Post("Blah");
$post->setArticle("Blah blah blah");
dump($post->render()); // big ole rendered HTML
