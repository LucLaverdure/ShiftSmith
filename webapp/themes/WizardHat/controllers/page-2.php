<?php


	class MySecondController extends Wizard\Build\Controller {

		function validate() {
			//if (q('h') && a('view content')) return 1;
			if (q("page2")) return 1;
			else return false;
		}

		function execute() {
			// My first Model
			// args: $var, $val, $id=null, $parent_id=null, $namespace="general"
			$myModel = new \Wizard\Build\Model("title","My Second Page!", "general");
			$main_img = new \Wizard\Build\Model("headImgSrc","/theme/files/img/sections/tutorials-bg.jpg", "general");

			$myMatrix = $this->Matrix(); // default Models List
			$myMatrix->space("guest")->def("id", "email", "name");
			$myMatrix->add(1, "mr@email.com", "Mr. Admin")
			  ->add(2, "ms@email.com", "Ms. Adminette")
			  ->add(888, "888@email.com", "Ms. 888")
			  ->add(3, "bob@email.com", "Bob the Admin");


			$myMatrix2 = $this->Matrix(); // default Models List
			$myMatrix2->space("guest")->def("id", "email", "name");
			$myMatrix2->add(6, "1@email.com", "One")
			  ->add(7, "2@email.com", "Two")
			  ->add(8, "3@email.com", "Three");

			$myMatrix3 = $this->Matrix(); // default Models List
			$myMatrix3->space("guest")->def("id", "email", "name");
			$myMatrix3->add(999, "999@email.com", "NIN")
			  ->add(111, "111@email.com", "TWIN")
			  ->add(222, "111@email.com", "THRIN");


			// Load HTML(DOM) Skeleton
			$myView = new Wizard\Build\View(); // or $myView = $this->View();
			$myView->from("body.html"); // declare fetch to be a template by filename
			$myView->render();

			// Load HTML(DOM) Skeleton
			$content = new Wizard\Build\View(); // or $myView = $this->View();
			$content->from("page2-content.html"); // declare fetch to be a template by filename
			$content->to(".page-content"); // declare fetch to be a template by filename
			$content->display_mode("append"); // declare fetch to be a template by filename
			$content->render();

		}

	}
