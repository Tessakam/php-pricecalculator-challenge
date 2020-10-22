<?php require '../View/includes/header.php' ?>
<!-- this is the view, try to put only simple if's and loops here.
Anything complex should be calculated in the model -->

<section class="container">
    <form action="index.php" method="post">
        <br>
        <H2>Price calculator</H2>
        <br>

        <div class="row">
            <div class="btn-group dropright">

                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false" class="dropdown-toggle" href="#">
                    <span id="selected">Choose your product</span> <span class="caret"></span>
                </button>

                     <ul class="dropdown-menu scrollable-menu" role="menu">
                    <?php foreach ($products as $product): ?>
                        <li><a class="dropdown-item" href="index.php?productDropdown=<?php echo $product['id'] ?>"
                               value="<?php echo $product['id'] ?>"
                               name="<?php echo $product['name'] ?>"><?php echo $product['name'] ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>

        <div class="row">
            <div class="btn group dropright">

                <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    Choose your customer
                </button>

                <ul class="dropdown-menu scrollable-menu" role="menu">
                    <?php foreach ($customers as $customer): ?>
                        <li><a class="dropdown-item" href="index.php?customerDropdown=<?php echo $customer['id'] ?>"
                               value="<?php echo $customer['id'] ?>"
                               name="<?php echo $customer['id'] ?>"><?php echo $customer['firstname'] . " " . $customer['lastname'] ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <br>
        <div>
            <p><input type="submit" class="btn btn-primary" name="submit" value="Submit"></p>
        </div>

        <br>
        <p>Your product: <strong><?php echo ucfirst($_SESSION["product"]->getName()); ?></strong></p>
        <p>Your customer: <strong><?php echo $_SESSION["customer"]->getFirstname()." ". $_SESSION["customer"]->getLastname(); ?></strong></p>

        <p>Initial price: </p>
        <p>Final price: </p>
        <br>
    </form>



</section>

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>
</body>

<?php require '../View/includes/footer.php' ?>

</html>

