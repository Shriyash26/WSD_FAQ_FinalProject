# WSD_Faq_FinalProject

#### Epic 1 : Verify user with email verification after registration.

1. After registration, system will send verification email to registered email-id.
2. User will not be able to login without verifying registered email-id.
3. To verify registered emailid, user should click on verification link send by system.
4. If user tries to login without verifying email-id, system will send new verification link to registered emailid.
5. Once email-id is verified, user will be able to login with valid credentials.

#### Epic 2 :  View all questions and answers posted on FAQ.
1. After successful login to the system, user should be able to view all questions and answers.
2. User should be able to create a new question.
3. User should be able to edit or delete questions created only by him/her.
4. User should be able to see email-id of question, answer owner and time of last update.
5. User should be able answer questions posted on FAQ.
6. User should be able to edit or delete answers posted only by him/her.

#### Epic 3: Unit Testing with Dusk and phpunit
- #### Testing with Dusk 
1. Unit-test should be able perform registration with new email id, verify email-id with verification link and login with verified account.
2. Unit-test should be able to test login with existing verified user.
3. Unit-test should be able to poerform create, edit, delete operations on Questions.
4. Unit-test should be able to poerform create, edit, delete operations on Answers.
5. Unit-Test should be able to create user profile details.
- #### Testing with phpunit
1. Feature test should be able to test register new user, email varification function.
2. Unit-test to perform login with valid credentials.
3. Negative Unit-test to check login with invalid credentials.
4. Unit-test to check data type of token.

- ### Note: 
    - ##### To run dusk tests, local server should be ON, as it requires broweser to perform tests.
    - ##### Please follow instructions on [https://laravel.com/docs/5.7/dusk] to install and configure system for dusk testing.
    - ##### To run and test email verification locally, use sendgrid or mailtrap account details. You need to update .env file with valid sendgrid or mailtrap credentials.
    - ##### Check spam folder for email verification mail if it does not appear in inbox.
    - ##### **[IMPORTANT] Sendgrid may suspend user account abruptly, which will prevent user from getting any email verification mail. This issue may happen with Heroku project. Please let me know if you face such issue, I will have to contact sendgrid support to activate account again.**
    
##
##

#### Heroku Project Link: [ https://wsd-finalproject.herokuapp.com/]
