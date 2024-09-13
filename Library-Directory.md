database/ 
    migration/ 
        creatte_authors_table.php
        create_books_table.php 
        create_category_table.php 
        create_borrowers_table.php 
        create_borrows_table.php 

app/
    Http/
        controllers/
            AuthorController.php
            BookController.php
            CategoryControlller.php
            BorrowerController.php
            BorrowController.php

    Models/ 
        Author.php 
        Book.php 
        Category.php 
        Borrower.php 
        borrow.php 

resource/
    views/ 
        layouts/ 
            app.php 

        Authors/ 
            index.blade.php 
            create.blade.php 
            edit.blade.php 
            report.blade.php 

        books/ 
            index.blade.php 
            create.blade.php
            edit.blade.php 
            report.blade.php  

        category/ 
            index.blade.php 
            create.blade.php 
            edit.blade.php 
            report.blade.php 

        Borrows/ 
            index.blade.php 
            create.blade.php 
            edit.blade.php 
            report.blade.php 

        borrowers/ 
            index.blade.php 
            create.blade.php 
            edit.blade.php 
            report.blade.php 
            
route/ 
    web.php 
