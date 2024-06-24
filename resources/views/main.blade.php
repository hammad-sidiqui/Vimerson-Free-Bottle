@extends('layouts.master')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-8 col-md-12 min-vh-100 col-xs-12 offset-lg-2 d-flex flex-column justify-content-center align-items-center">

            <!-- logo -->
            <img src="{{asset('images/logo.png')}}" class="logo mb-4" alt="vimerson" />

            <h3 class="col-lg-9 free-bottle-title mt-3 text-center">Give us your feedback and we’ll give you a free product of your choice!</h3>
            <!-- multistep form -->
            <form class="form-horizontal form mt-5" id="form" method="POST" action="">
                <!-- progressbar -->
                <ul id="progressbar">
                    <li class="active"></li>
                    <li></li>
                    <li></li>
                    <li></li>
                </ul>

                <div class="loader-overlay" style="display: none;">
                    <div class="loader">
                        <span></span>
                        <span></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div id="sucess-msg" style="display:none;">
                        <h2 class="fs-subtitle" style="color: #5abe26; font-size:15px; text-align:center;">Form
                            Submitted Successfully</h2>
                    </div>
                    <div id="error-msg" style="display:none;">
                        <h2 class="fs-subtitle" style="color: #dc3c52; font-size:15px; text-align:center;">Oops..
                            Something wrong.</h2>
                    </div>
                </div>

                <!-- fieldsets -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <fieldset id="step1">
                                    <h2 class="step-title">Personal Details</h2>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3 required">
                                                <label class="control-label">First Name <span class="required-asterisk">*</span></label>
                                                <input type="text" class="form-control" id="first_name" name="first_name" />
                                            </div>                                            
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3 required">
                                                <label class="control-label">Last Name <span class="required-asterisk">*</span></label>
                                                <input type="text" class="form-control" id="last_name" name="last_name" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3 required">
                                                <label class="control-label">Email <span class="required-asterisk">*</span></label>
                                                <input type="email" class="form-control" id="email" name="email" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3 required">
                                                <label class="control-label">Phone Number <span class="required-asterisk">*</span></label>
                                                <input type="text" class="form-control number-only" id="phone_number" name="phone_number" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4"></div>
                                    <input style="float:right;" type="button" id="stepone" name="next" class="next action-button" value="Next" />

                                    <div class="terms-conditions float-left mt-3 pt-3">
                                        <h6 style="">Terms &amp; Conditions</h6>
                                        <!-- <p>Limit one free product per customer. This offer is only valid for products bought on <a href="https://www.amazon.com/" target="_blank">Amazon.com</a>. To qualify for this offer, customers
                                            should be actively taking a product for at least 14 days and agree to share
                                            their experience with the purchased product. This offer is valid no matter
                                            what feedback a customer provides, whether it is positive or negative. Offer
                                            only valid in the USA.</p> -->
                                            <p>
                                            Offer only valid in the USA. You will be eligible to claim one free bottle of supplements for each different product featuring the relevant promotional label. To claim your free bottle, you should have been actively taking your supplements for 14 days and be prepared to share your experience of the product by providing an honest review. This will help us to improve our products for you and our other customers!
                                            </p>
                                    </div>

                                </fieldset>


                                <fieldset id="step2">

                                    <h2 class="step-title">Order Details</h2>
                                    <div class="row g-3">
                                    <div class="col-lg-5">
                                            <div class="order-divider pe-lg-3">
                                                <div class="form-group mb-3 required">
                                                    <label class="control-label">Please enter your Amazon Order Number <span class="required-asterisk">*</span></label>
                                                    <input type="text" class="form-control" id="order_id" name="order_id" />
                                                    <a href="https://www.amazon.com/gp/css/order-history" target="_blank" class="mb-4 d-block mt-3 fs-13">Click here to access your Amazon Order History</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-7 ps-lg-3s">
                                            <label class="control-label w-100 text-center">Here's where to find your Amazon Order Number</label>
                                            <a href="https://www.amazon.com/gp/your-account/order-history" target="_blank" class="mb-4 d-block">
                                                <div class=""><img src="{{asset('images/amazon_order.png')}}" class="w-100 mb-4" /></div>
                                            </a>
                                        </div>
                                        

                                        <div class="float-left mt-3 pt-3 amazon-order-error" style="display: none;">
                                            <h6 style="color: #f45b5d">Error</h6>
                                            <p>Oops! We can’t find that order number, please check the number. You can  <a href="https://www.amazon.com/gp/your-account/order-history/ref=ppx_yo2_dt_b_search?opt=ab&amp;search=vimerson" target="_blank">access your Amazon Order details here</a>  or contact our Customer Happiness  Team who will be glad to help you.  You can reach our friendly team via the chat button on the bottom right  of the screen, by calling <a href="tel:+8009103491" target="_blank">(800) 910-3491</a> or email us at<strong> </strong><a data-link-card="true" href="mailto:info@vimerson.com" target="_blank">info@vimerson.com</a>. </p>
                                        </div>

                                        <!-- <div class="col">
                                           <div class="form-group mb-3 required">
                                               <label class="control-label">ASIN Number <span
                                                       class="required-asterisk">*</span></label>
                                               <input type="text" class="form-control" name="asinID" />
                                           </div>
                                        </div> -->
                                    </div>
                                    <div class="mt-4"></div>

                                    <input type="button" name="back" id="back1" class="back action-button" value="back" />
                                    <input style="float:right;" type="button" id="steptwo" name="next" class="next action-button" value="Next" />
                                </fieldset>

                                <fieldset id="step3">
                                    <h2 class="step-title">CHOOSE YOUR FREE SUPPLEMENT(S)</h2>
                                    
                                    <div class="qualify-bottles-alert mb-3"></div>

                                    <div class="free-bottles"></div>
                                    <label id="bottle-error" class="error" for="bottle"></label>

                                    <h2 class="product-experience-title">Tell Us What You Think</h2>
                                    <div class="row mb-3">
                                        <div class="rating-stars text-center">
                                            <h5>Please rate the product that you recently purchased</h5>
                                            <ul id="stars">
                                                <li class="star" title="Poor" data-value="1">
                                                    <i class="bi bi-star-fill"></i>
                                                </li>
                                                <li class="star" title="Fair" data-value="2">
                                                    <i class="bi bi-star-fill"></i>
                                                </li>
                                                <li class="star" title="Good" data-value="3">
                                                    <i class="bi bi-star-fill"></i>
                                                </li>
                                                <li class="star" title="Excellent" data-value="4">
                                                    <i class="bi bi-star-fill"></i>
                                                </li>
                                                <li class="star" title="WOW!!!" data-value="5">
                                                    <i class="bi bi-star-fill"></i>
                                                </li>
                                            </ul>
                                            <label id="stars-error" class="error" for="stars" style="display: none;">The stars field is required.</label>
                                        </div>
                                    </div>

                                    <div class="row g-3 mb-5">
                                        <div class="col">
                                            <div class="form-group mb-3 required">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <label class="control-label">We’re always on the lookout for ways to improve our supplements. By leaving an honest review, we can achieve this. It will help other customers to choose the right supplements for themselves too!<span class="required-asterisk">*</span>
                                                        </label>
                                                    </div>

                                                    <!-- <div class="col-md-2" style="text-align: right;">
                                                        <label class="control-label"><span id="feedback-count">0</span>/1000</label>
                                                    </div> -->
                                                </div>
                                                <textarea id="feedback"></textarea>
                                                <label id="feedback-error" class="error" for="feedback">The feedback field is required.</label>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <h2 class="step-title">Questionnaire</h2>
                                    <div class="questionnaire-block"></div> -->

                                    <!-- <div class="row">
                                        <div class="col">
                                            <div class="form-group mb-3 questionnaire">
                                                <label class="control-label question">
                                                    <span class="font-weight-bold">Q 1.</span> Where did you first hear
                                                    about us? </label>
                                                <textarea id="answer_one" class="answer"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                        
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group mb-3 questionnaire">
                                                <label class="control-label question">
                                                    <span class="font-weight-bold">Q 2.</span> Have you used our product
                                                    before? </label>
                                                <textarea id="answer_two" class="answer"></textarea>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="mt-4"></div>
                                    <div class="d-md-flex justify-content-between">
                                        <input type="button" name="back" id="back2" class="back action-button me-2" value="back" />
                                        <div class="d-md-flex">
                                            <input type="button" id="popup_amazon_feedback" class="back action-button me-2" value="Go to Amazon Feedback"/>
                                            <input type="button" id="stepthree" name="next" class="next action-button" value="Next"/>
                                        </div>
                                    </div>
                                </fieldset>


                                <fieldset id="step4">
                                    <!-- <h2 class="step-title">Confirmation</h2>

                                    <div class="mt-4"></div>

                                    <div class="confirmation-details mb-5"></div> -->

                                    <h2 class="step-title">Please confirm that your Shipping Address is correct</h2>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <div class="form-group required">
                                                <label class="control-label">First Name <span class="required-asterisk">*</span></label>
                                                <input type="text" class="form-control" id="shipping_name" name="shipping_name" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group required">
                                                <label class="control-label">Last Name <span class="required-asterisk">*</span></label>
                                                <input type="text" class="form-control" id="shipping_last_name" name="shipping_last_name" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group required">
                                                <label class="control-label">Phone <span class="required-asterisk">*</span></label>
                                                <input type="text" class="form-control" id="shipping_phone" name="shipping_phone" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col">
                                            <div class="form-group mb-3 required">
                                                <label class="control-label">Address <span class="required-asterisk">*</span></label>
                                                <input type="text" class="form-control" id="shipping_address" name="shipping_address" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-md-4">
                                            <div class="form-group required">
                                                <label class="control-label">City <span class="required-asterisk">*</span></label>
                                                <input type="text" class="form-control" id="shipping_city" name="shipping_city" />
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group required">
                                                <label class="control-label">State <span class="required-asterisk">*</span></label>
                                                <select class="form-select" id="shipping_state" name="shipping_state"> </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group required">
                                                <label class="control-label">Zip <span class="required-asterisk">*</span></label>
                                                <input type="text" minlength="5" maxlength="5" class="form-control number-only" id="shipping_zip" name="shipping_zip" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-5"></div>
                                    <input type="button" name="back" id="back3" class="back action-button" value="back" />
                                    <input style="float:right;" type="button" id="stepfour" name="submit" class="submitbutton" value="Get my free supplement" />

                                </fieldset>

                                <fieldset id="step5">

                                    <h2 class="step-title">Thank you</h2>
                                    <div class="row g-3">
                                        <div class="col-lg-8 offset-lg-2 col-md-10 offset-md-1">
                                            <div class="thank-you">
                                                <p>Thank you for ordering your free supplement and sharing your feedback with
                                                    us! We will send you a confirmation email soon!</p>
                                                <p>If you have any questions please contact us <a href="mailto:info@vimerson.com">info@vimerson.com</a></p>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="last-step-footer text-center mt-3 pt-3 w-100">
                                        <h6><a href="https://www.vimerson.com" target="_blank">www.vimerson.com</a></h6>
                                    </div>
                                    <!--<div class="mt-4"></div>-->
                                    <!--<input type="button" name="back" id="back4" class="back action-button"-->
                                    <!--    value="back" />-->

                                    <!--<input style="float:right;" type="button" id="stepfive" name="next"-->
                                    <!--    class="next action-button" value="Next" />-->
                                </fieldset>

                                <!--<fieldset id="step6">-->
                                <!--    <div class="mt-4"></div>-->
                                <!--    <input type="button" name="back" id="back5" class="back action-button"-->
                                <!--        value="back" />-->

                                <!--    <input style="float:right;" type="submit" id="stepsix" name="submit" class="submitbutton" value="Submit" />-->

                                <!--</fieldset>-->
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="popup_feedback" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Amazon Feedback</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            
            <h2 class="modal-product-experience-title">Share your Product Experience with us!</h2>
            <div class="row">
                <div class="rating-stars text-center">
                    <ul id="stars">
                        <li class="star" title="Poor" data-value="1">
                            <i class="bi bi-star-fill"></i>
                        </li>
                        <li class="star" title="Fair" data-value="2">
                            <i class="bi bi-star-fill"></i>
                        </li>
                        <li class="star" title="Good" data-value="3">
                            <i class="bi bi-star-fill"></i>
                        </li>
                        <li class="star" title="Excellent" data-value="4">
                            <i class="bi bi-star-fill"></i>
                        </li>
                        <li class="star" title="WOW!!!" data-value="5">
                            <i class="bi bi-star-fill"></i>
                        </li>
                    </ul>
                    <label id="stars-error" class="error" for="stars" style="display: none;">The stars field is required.</label>
                </div>
            </div>

            <div class="row">
                <div class="col-md-10">
                    <label class="control-label">Please be specific, on how you've been using it & how it's benefiting you<span class="required-asterisk">*</span>
                    </label>
                </div>
            </div>
            <textarea id="amazon_feedback" readonly></textarea>

        </div>
        <div class="modal-footer">
            <button type="button" class="modal-close" data-bs-dismiss="modal">Close</button>
            <a target="_blank" id="publish_to_amazon" href="https://www.amazon.com/review/create-review" class="publish-to-amazon">Publish to amazon</a>
        </div>
      </div>
    </div>
</div>
{{-- #Modal --}}

<div class="intercom-message" style="display: none;">
    <a class="intercom-message-close-btn">
        <svg width="8" height="8" viewBox="0 0 23 23" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" fill="white" d="M9.34583 11.2L0.384011 2.23818C-0.128004 1.72617 -0.128004 0.896026 0.384011 0.384011C0.896026 -0.128004 1.72617 -0.128004 2.23818 0.384011L11.2 9.34583L20.1618 0.384011C20.6738 -0.128004 21.504 -0.128004 22.016 0.384011C22.528 0.896026 22.528 1.72617 22.016 2.23818L13.0542 11.2L22.016 20.1618C22.528 20.6738 22.528 21.504 22.016 22.016C21.504 22.528 20.6738 22.528 20.1618 22.016L11.2 13.0542L2.23818 22.016C1.72617 22.528 0.896026 22.528 0.384011 22.016C-0.128003 21.504 -0.128003 20.6738 0.384011 20.1618L9.34583 11.2Z"></path></svg>
    </a>
    <a class="intercom-message-text">
        <p class="">Hi there!  How can I help?</p>
    </a>
</div>

@endsection