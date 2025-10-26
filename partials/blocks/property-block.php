<?php
$description_content = get_sub_field('description_content');
?>
<section class="single-property py-5">
    <div class="container">
        <div class="row align-items-start">

            <!-- Left: Main content -->
            <div class="col-lg-8">

                <!-- Property Header -->
                <div class="property-header mb-4">
                    <span class="badge bg-success">For Sale</span>
                    <h1 class="property-title mt-2">Amazing modern apartment</h1>
                    <p class="property-location text-muted mb-2">43 W. Wellington Road Fairhope, AL 36532</p>
                    <div class="property-price fw-bold fs-4 text-dark">
                        $120,000 <span class="text-muted fs-6">/ $1200 per sq.ft</span>
                    </div>
                </div>

                <!-- Property Gallery -->
                <div class="property-gallery mb-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="main-image rounded-4 overflow-hidden">
                                <img src="https://picsum.photos/id/20/800/400" class="img-fluid w-100" alt="Main property image">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="property-description mb-5">
                    <h4>Description</h4>
                    <p>Lorem ipsum dolor sit amet consectetur. Morbi quis habitant donec aliquet interdum...</p>
                    <p>Ut pellentesque lectus auctor aenean urna. Lectus vestibulum sit et cursus...</p>
                </div>

                <!-- Property Details -->
                <div class="property-details">
                    <h4>Property details</h4>
                    <div class="details-grid mt-3">
                        <div class="detail-item">
                            <i class="fa-solid fa-ruler-combined"></i>
                            <span>Total area</span>
                            <strong>100 sq.ft</strong>
                        </div>
                        <div class="detail-item">
                            <i class="fa-solid fa-bed"></i>
                            <span>Bedrooms</span>
                            <strong>2</strong>
                        </div>
                        <div class="detail-item">
                            <i class="fa-solid fa-bath"></i>
                            <span>Bathrooms</span>
                            <strong>2</strong>
                        </div>
                        <div class="detail-item">
                            <i class="fa-solid fa-layer-group"></i>
                            <span>Floor</span>
                            <strong>3rd</strong>
                        </div>
                        <div class="detail-item">
                            <i class="fa-solid fa-elevator"></i>
                            <span>Elevator</span>
                            <strong>Yes</strong>
                        </div>
                        <div class="detail-item">
                            <i class="fa-solid fa-square-parking"></i>
                            <span>Parking</span>
                            <strong>2</strong>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right: Contact Agent -->
            <div class="col-lg-4">
                <div class="col-12">
                    <div class="small-image rounded-4 overflow-hidden position-relative">
                        <img src="https://picsum.photos/id/42/400/200" class="img-fluid w-100" alt="Show all photos">
                        <div class="overlay d-flex flex-column align-items-center justify-content-center">
                            <i class="fa-solid fa-camera mb-1"></i>
                            <span>Show all<br><strong>12 photos</strong></span>
                        </div>
                    </div>
                </div>
                <div class="col-12 my-4">
                    <div class="small-map rounded-4 overflow-hidden">
                        <img src="https://picsum.photos/id/57/400/200?text=Map" class="img-fluid w-100" alt="Map preview">
                    </div>
                </div>
                <div class="contact-agent bg-dark text-white p-4 rounded-4">
                    <h5 class="mb-4">Contact agent</h5>
                    <div class="agent-info d-flex align-items-center mb-4">
                        <div class="agent-photo rounded-circle overflow-hidden me-3" style="width: 60px; height: 60px;">
                            <img src="https://picsum.photos/id/1005/100/100" class="img-fluid w-100" alt="Agent photo">
                        </div>
                        <div>
                            <strong>Emilia Buck</strong><br>
                            <small>(431) 402-2459</small><br>
                            <small class="text-white">rsamartin@optonline.net</small>
                        </div>
                    </div>

                    <form>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Your name">
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Your mail">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Your phone">
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" rows="3" placeholder="Your message"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Send message</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>