<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">New Course</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row mb-5 px-3">
              <label class="form-check-label col-4 my-auto" for="flexCheckDefault">
              Course Name:
              </label>
              <div class="col-8 mx-auto"><input type="text" class="form-control w-100" id="otherArea"></div>
          </div>
          <div class="row mb-5 px-3">
              <label class="form-check-label col-4" for="flexCheckDefault">
              Description:
              </label>
              <div class="col-8 mx-auto"><textarea name="txtreview" maxlength="150" class="form-control" rows="5" style="resize:none;" placeholder="Enter your review here.."></textarea></div>
          </div>
          <div class="row px-3 mb-3">
              <label class="form-check-label col-4 my-auto" for="flexCheckDefault">
              Videos:
              </label>
              <div class="col-8 mx-auto">
                  <input type="file" accept="video/*" class="form-control" name="cert">
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Discard</button>
          <button type="button" class="btn btn-primary">Create</button>
        </div>
      </div>
    </div>
  </div>