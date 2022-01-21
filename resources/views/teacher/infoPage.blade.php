@include('header',['Title'=>"Teacher Information Page"])
<section class="">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12">
                <div class="card border border-5" style="border-radius: 1rem;">
                    <div class="card-body pt-3 px-5 pb-4">
                        <div class="mt-md-4 pb-0">
                            <label class="fw-bold mb-5 text-uppercase">Please answer the following question, and you will be enrolled as the teacher if you received our email.</label>
                            <div class="container">
                                <div class="row gx-5 gy-3">
                                    <div class="mb-3 col-12 col-sm-6">
                                        <label for="exampleFormControlInput1" class="form-label pb-2">1. First name</label>
                                        <input type="text" class="form-control" id="fname">
                                    </div>
                                    <div class="mb-3 col-12 col-sm-6">
                                        <label for="exampleFormControlInput1" class="form-label pb-2">2. Last Name</label>
                                        <input type="text" class="form-control" id="lname">
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label class="mb-3" onselectstart="return false" style="font-size:17px;">3. Which content area(s) do you specialize in? (At Least select ONE)</label><br>
                                        <div class="ms-4 row gy-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="areaSc">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Science
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="areaTech">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Technology
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="areaEng">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Engineering
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="areaMath">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Mathematics
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="areaOther">
                                                <div class="row">
                                                    <label class="form-check-label col-auto my-auto" for="flexCheckDefault">
                                                    Other:
                                                    </label>
                                                    <div class="col-sm-6 col-12 my-auto"><input type="text" class="form-control" id="otherArea"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label class="mb-3" onselectstart="return false" style="font-size:17px;">4. How many years have you been worked in the field of education?</label><br>
                                        <div class="ms-4 row gy-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="expYear" id="Ayear" value="option1">
                                                <label class="form-check-label" for="Ayear">
                                                    0 to 3 years
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="expYear" id="Cyear" value="option2">
                                                <label class="form-check-label" for="Cyear">
                                                    4 to 5 years
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="expYear" id="Cyear" value="option3">
                                                <label class="form-check-label" for="Cyear">
                                                    6 to 10 years
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="expYear" id="Dyear" value="option4">
                                                <label class="form-check-label" for="Dyear">
                                                    More than 10 years
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label class="mb-3" onselectstart="return false" style="font-size:17px;">5. What is your primary reason for enrolling in this STEMDEMY?</label><br>
                                        <div class="ms-4 row gy-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="reason1">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Professional growth
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="reason2">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    I am responsible for providing professional development for my school or district
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="reason3">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    I am just curious and find interesting about STEMDEMY
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="reasonOther">
                                                <div class="row">
                                                    <label class="form-check-label col-auto my-auto" for="flexCheckDefault">
                                                    Other reason:
                                                    </label>
                                                    <div class="col-sm-6 col-12 my-auto"><input type="text" class="form-control" id="otherReason"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label class="mb-3" onselectstart="return false" style="font-size:17px;">6. Is this your first online professional development experience?</label><br>
                                        <div class="ms-4 row gy-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="firstTime" id="firstTimeTrue" value="option1">
                                                <label class="form-check-label" for="firstTimeTrue">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="firstTime" id="firstTimeFalse" value="option2">
                                                <label class="form-check-label" for="firstTimeFalse">
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <label class="mb-3" onselectstart="return false" style="font-size:17px;">7. Upload your certificate (Optional)</label><br>
                                        <input type="file" accept=".xlsx,.xls,image/*,.doc, .docx,.ppt, .pptx,.txt,.pdf" class="form-control" name="cert">
                                    </div>
                                    <div class="col-12 mt-2 mb-4 row">
                                        <div class="checkbox my-4" onselectstart="return false">
                                            <label class="ms-5">
                                                <input type="checkbox" value="agree"> I have agree with the storage and handling of my data by STEMDEMY in accordance with the
                                                <a href="#!" class="text-blue-50 fw-bold">Privacy Policy</a>
                                            </label>
                                        </div>
                                        <button class="w-auto btn btn-lg btn-primary mt-3 mx-auto" type="submit">Submit</button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('footer')