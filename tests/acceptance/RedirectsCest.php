<?php 
/**
 * Testing class to make sure redirects are working.
 */
class RedirectsCest {
	/**
	 * Tests that the admin user is redirected to the correct page.
	 *
	 * @param AcceptanceTester $I - acceptance object sent by codeception
	 * @return void
	 */
	public function test_admin_login( AcceptanceTester $I ) {
		$I->amGoingTo( 'Try and test something' );
		$I->amOnPage( '/wp-admin' );
		$I->fillField( '#user_login', 'admin');
		$I->fillField( '#user_pass', 'password');
		$I->click( '#wp-submit' );
		$I->see('Dashboard');
		$this->logout($I);

	}
	/**
	 * Tests that the editor user is redirected to the correct page.
	 *
	 * @param AcceptanceTester $I - acceptance object sent by codeception
	 * @return void
	 */
	public function test_editor_login( AcceptanceTester $I ) {
		$I->amGoingTo( 'Try and test that the editor user is redirected to a page on login' );
		$I->amOnPage( '/wp-admin' );
		$I->fillField( '#user_login', 'editor');
		$I->fillField( '#user_pass', 'password');
		$I->click( '#wp-submit' );
		$I->wait(2);
		$I->see('Page for Editor');
		$this->logout($I);

	}
	/**
	 * Tests that the contributor user is redirected to the correct page.
	 *
	 * @param AcceptanceTester $I - acceptance object sent by codeception
	 * @return void
	 */
	public function test_contributor_login( AcceptanceTester $I ) {
		$I->amGoingTo( 'Try and test that the contributor user is redirected to a page on login' );
		$I->amOnPage( '/wp-admin' );
		$I->fillField( '#user_login', 'contributor');
		$I->fillField( '#user_pass', 'password');
		$I->click( '#wp-submit' );
		$I->wait(2);
		$I->see('Page for Contributor');
		$this->logout($I);	
	}

	private function logout( AcceptanceTester $I ) {
		$I->moveMouseOver('#wp-admin-bar-my-account');
		$I->click( 'Log Out' );
	}
}
