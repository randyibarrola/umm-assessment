<?php
    include_once 'LibraryService.php';
    include_once 'SearchResponse.php';
?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>

<header class="p-3 mb-3 border-bottom">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-dark text-decoration-none">
                <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
            </a>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
                <li>UMEMA Sr. Software Engineer Take Home Assessment</li>
            </ul>

            <div class="text-end">
                <a href="https://www.linkedin.com/in/randy-ibarrola-1bb67170/" class="d-block link-dark text-decoration-none" aria-expanded="false">
                    <label class="success">Randy Ibarrola</label>
                    <img src="https://github.com/mdo.png" alt="mdo" width="32" height="32" class="rounded-circle">
                </a>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h2>Library Book Search</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="index.php" method="post" class="row g-3">
                <div class="col-md-6">
                    <label for="isbn" class="form-label">Enter ISBN</label>
                    <input type="text" name="isbn" class="form-control" id="isbn">
                </div>
                <div class="col-12">
                    <button type="submit" name="" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
    </div>
    <?php if(isset($_POST['isbn'])):
        $controller = new LibraryService();
    ?>
        <div class="row">
            <div class="col-12">
                <hr>
                <?php
                    $response = $controller->searchBook();
                    if ($response->success) :
                ?>
                    <div class="alert alert-success" role="alert">
                        Results
                    </div>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Book Title</b>: <?php echo $response->bookTitle ?></li>
                        <li class="list-group-item"><b>Book Published Date</b>: <?php echo $response->publishDate ?></li>
                        <li class="list-group-item"><b>Author Name</b>: <?php echo $response->authorName ?></li>
                        <li class="list-group-item"><b>Author Biography</b>: <p><?php echo $response->authorBiography ?></p></li>
                        <li class="list-group-item"><b>Author Other Books</b>: <?php echo implode(', ', $response->works) ?></li>
                    </ul>
                <?php else : ?>
                        <div class="alert alert-danger" role="alert">
                            Book Not Found
                        </div>
                <?php endif ?>
            </div>
        </div>
    <?php endif ?>
</div>



<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
-->
</body>
</html>