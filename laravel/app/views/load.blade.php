@extends("layout")
@section("content")
	<?php
include_once("../../arc2-master/ARC2.php");

$configLocal = array(
  'db_name' => 'rdfdemo',
  'db_user' => 'root',
  'db_pwd' => '',
  'store_name' => 'arc_rdf',
  'max_errors' => 100,
);

$storeLocal = ARC2::getStore($configLocal);
if (!$storeLocal->isSetUp()) {
  $storeLocal->setUp();
}

$config = array('remote_store_endpoint' => 'http://dbpedia.org/sparql',);
$store = ARC2::getRemoteStore($config);

$query = '
PREFIX owl: <http://www.w3.org/2002/07/owl#>
PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
PREFIX foaf: <http://xmlns.com/foaf/0.1/>
PREFIX dc: <http://purl.org/dc/elements/1.1/>
PREFIX : <http://dbpedia.org/resource/>
PREFIX dbpedia2: <http://dbpedia.org/property/>
PREFIX dbpedia: <http://dbpedia.org/>
PREFIX skos: <http://www.w3.org/2004/02/skos/core#>
PREFIX dbpedia-owl: <http://dbpedia.org/ontology/>
PREFIX dcterms: <http://purl.org/dc/terms/>
PREFIX category: <http://dbpedia.org/resource/Category:>

SELECT DISTINCT *
WHERE  {{?x dcterms:subject category:Middle-earth_realms}
 UNION {?x dcterms:subject category:Middle-earth_castles_and_fortresses}
 UNION {?x dcterms:subject category:Middle-earth_races}
 UNION {?x dcterms:subject category:Middle-earth_Orcs}
 UNION {?x dcterms:subject category:The_Lord_of_the_Rings_characters}
 UNION {?x dcterms:subject category:Middle-earth_rulers}
 UNION {?x dcterms:subject category:High_Elves}
 UNION {?x dcterms:subject category:Middle-earth_Dwarves}
 UNION {?x dcterms:subject category:Middle-earth_Men}
 UNION {?x dcterms:subject category:Middle-earth_Dragons}
 UNION {?x dcterms:subject category:Middle-earth_animals}
 UNION {?x dcterms:subject category:Middle-earth_Maiar}
 UNION {?x dcterms:subject category:Middle-earth_Valar}
}
';

$r = '';
if ($rows = $store->query($query, 'rows')) {
  foreach ($rows as $row) {
    $r .= '<li>' . $row['x'] . '</li>';
    $storeLocal->query('LOAD <'.$row['x'].'>');
  }
}

echo $r ? '<ul>' . $r . '</ul>' : 'no named persons found';

?>
@stop
