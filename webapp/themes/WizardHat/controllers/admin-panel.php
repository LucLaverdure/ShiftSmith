<?php
	class Admin_Panel extends Wizard\Build\Controller {

		function validate() {
			if (route("/") && access("admin")) {
				return -999;
			}
			return false;
		}

		function execute() {

			Model("title", "Wizard.Build", "site");
			
			$slogans = array();
			$slogans[] = "I believe in magic!";
			$slogans[] = "Magic is believing";
			$slogans[] = "Wanna see a trick?";
			$slogans[] = "Poof!";
			$slogans[] = "Pick a card, any card.";
			$slogans[] = "I can read your mind";
			$slogans[] = "What's that in your ear?";
			$slogans[] = "The wand is mightier than the sword";
			$slogans[] = "Be sure to remember your card!";
			$slogans[] = "Science in our skills, magic in our hands.";
			$slogans[] = "Experience the magic onboard.";
			$slogans[] = "Feel the magic up close.";
			$slogans[] = "There is no magic pill, just lots of hard work and dedication.";
			$slogans[] = "What magic feels like.";
			$slogans[] = "Find your magic.";
			$slogans[] = "Big hugs and magic kisses included";
			$slogans[] = "Let's Make Magic.";
			$slogans[] = "May your days be filled with magic and cheer!";
			$slogans[] = "Discover the Magic.";
			$slogans[] = "Where The Magic Never Ends.";
			
			shuffle($slogans);
			
			Model("subtitle", array_shift($slogans), "site");
			
			//stack_resource("https://cloud.tinymce.com/5/tinymce.min.js");
			
			$myView = View(); // or $myView = $this->View();
			$myView->from("admin-skeleton.html"); // declare fetch to be a template by filename
			$myView->render(); // declare fetch to be a template by filename

			$myView2 = View(); // or $myView = $this->View();
			$myView2->from("admin-panel.html"); // declare fetch to be a template by filename
			$myView2->to("body"); // declare fetch to be a template by filename
			$myView2->render("prepend"); // declare fetch to be a template by filename


		}

	}
