<?php require '../includes/header.php'?>
<!-- this is the view, try to put only simple if's and loops here.
Anything complex should be calculated in the model -->

<section class="container">
    <form action="index.php" method="post">
    <div class="dropdown open">
        <button class="btn btn-secondary dropdown-toggle"
                type="button" id="dropdownMenu4" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            Product
        </button>

        <div class="dropdown-menu">
            <?php foreach ($products as $product): ?>
            <a class="dropdown-item" href="index.php?productDropdown=<?php echo $product['id'] ?>" value="<?php echo $product['id'] ?>" name="<?php echo $product['name'] ?>" ><?php echo $product['name'] ?></a>
            <?php endforeach; ?>
        </div>

    </div>

    <div class="dropdown open">
        <button class="btn btn-secondary dropdown-toggle"
                type="button" id="dropdownMenu4" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            Customer
        </button>
        <div class="dropdown-menu">
            <?php foreach ($customers as $customer): ?>
                <a class="dropdown-item" href="index.php?customerDropdown=<?php echo $customer['id'] ?>" value="<?php echo $customer['id'] ?>" name="<?php  echo $customer['id'] ?>" ><?php echo $customer['firstname']." ".$customer['lastname'] ?></a>
            <?php endforeach; ?>
        </div>

        <p><input type="submit" class="btn btn-primary" name="submit" value="Submit"></p>
    </div>
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

<?php require '../includes/footer.php'?>

</html>

