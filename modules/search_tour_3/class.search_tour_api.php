<?php
 class Search_Tour_Api extends Search_Api { protected function filterTownFrom($town) { return (Samo::TOWNFROMHOTELINC != $town['id']); } } 