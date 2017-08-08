#compile the app for Neko runtime
compile_neko:
	haxe sugoiNeko.hxml

#compile the app for PHP5 runtime
compile_php : 
	haxe sugoiPHP.hxml

#generate translated templates and precompile templates	
templates:
	haxe templateGeneration.hxml
	(cd lang/en/tpl; temploc2 -macros macros.mtt -output ../tmp/ *.mtt )
	(cd lang/fr/tpl; temploc2 -macros macros.mtt -output ../tmp/ *.mtt )

#generate pot file for translation	
update_pot:
	haxe potGeneration.hxml