<?php
include './components/head_css.php';
include './components/navbar.php';
?>

<!-- Start Hero Section -->
<div class="hero p-1 ">
    <div class="container pt-4 ">
        <div class="row justify-content-between">
            <div class="col-lg-12">
                <div class="text-center">
                    <h1>CONTACT US</h1>

                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Hero Section -->


<!-- Start Contact Form -->
<div class="untree_co-section " style="background-image: url('images/bannercactus.png'); background-size: cover; ">
    <div class="container">

        <div class="block">
            <div class="row justify-content-center px-3">


                <div class="col-md-8 col-lg-6 p-4 bg-dark rounded">



                    <form>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="text-white" for="fname">First name</label>
                                    <input type="text" class="form-control" id="fname">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="text-white" for="lname">Last name</label>
                                    <input type="text" class="form-control" id="lname">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-white" for="email">Email address</label>
                            <input type="email" class="form-control" id="email">
                        </div>

                        <div class="form-group mb-5">
                            <label class="text-white" for="message">Message</label>
                            <textarea name="" class="form-control" id="message" cols="30" rows="5"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary-hover-outline"
                            style="background-color: #fe827a;">Send Message</button>
                    </form>


                </div>

            </div>

        </div>

    </div>


</div>
</div>

<!-- End Contact Form -->

<?php
include './components/bottom-script.php';
?>