@extends("layout")
@section("content")
<div class ="jumbotron">
		<h1>Projekt-Idee</h1>
			<p>Die Idee hinter "Planning Poker App" ist es, Planning Poker zu vereinfachen indem wir die lästigen Berechnungen automatisch durchführen und die herum fliegenden Karten abschaffen. Um die Benutzung der App einfach zu gestalten, muss sich nur der Moderator registrieren. Nicht jeder beliebige User kann der Abstimmung beitreten, denn sie ist vom Moderator durch ein Passwort gesichter. Die Webapp soll auch von zu Hause verwendet werden können, allerdings ist es vorteilhaft zusätzlich an einer Telefonkonferenz teilzunehmen, da sonst nicht über die Ergebnisse diskutiert werden kann.</p>
		<h1>Wie kam es zu dem Projekt?</h1>
			<p>Als wir im Projektmanagement-Unterricht Planning Poker ausprobiert haben, waren die anschließenden Berechnungen sehr umständlich und einige Gruppen haben es erst mit viel Hilfe und nach mehrmaligem Nachfragen geschafft. Diese Arbeit wollen wir allen Planning Poker Nutzern ersparen. Die relativ kleinen Karten gehen leicht verloren, was mit unserer Webapp nicht mehr passieren kann. Trotzdem bleibt das Gefühl mit Karten zu werten.</p>
		<h1>Das Team</h1>
			<p>Das Team besteht aus Larissa Reitler, der Projektleiterin, die außerdem für Design und Grafiken zuständig ist. Manuela Greifoner ist stellvertretende Projektleiterin und für die Auswertung der Daten zuständig. Sabine Schimpf programmiert die Client-Seitige-Anwendung und Markus Zwettler ist für die Kommunikation zwischen Server und Client verantwortlich.</p>
		<h1>Was ist Planning Poker?</h1>
			<p>Planning Poker ist eine einfache Methode um den Aufwand jeder einzelnen User-Story in einem Projekt zu schätzen. Hierfür bekommt jeder Teilnehmer einen Satz Karten die den geschätzten Aufwand darstellen. Auf ihnen befinden sich Zahlen und Zusatzkarten wie einem Fragezeichen und einer Kaffeetasse. Die Fragezeichen-Karte bedeutet, dass die Person keine Ahnung hat, wie groß der Aufwand dieser User-Story sein könnte. Die Kaffeetasse symbolisiert, dass die Person eine Pause benötigt.</p>
		<h1>Wer kann die App nutzen?</h1>
			<p>Die App kann jeder nutzen der Planning Poker durchführen möchte. Um eine Anwendung zu starten, muss eine Person sich als Moderator registrieren. Als abstimmender User benötigt man das vom Moderator erstelle Session-Passwort und den dazu gehörigen Session-Namen um der Planning Poker Session beitreten zu können. Außerdem muss sich der User zur Identifikation einen Nickname geben.</p>
</div>
@stop

@section("js")
<script>
	$("#li_aboutus").toggleClass( "active", true);
</script>
@stop