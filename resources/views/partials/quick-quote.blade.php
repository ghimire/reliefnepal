<div class="panel panel-primary shadow-z-2">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fa fa-list-ul"></i> Quick Quote
        </div>
    </div>
    <div class="panel-body">
        <form id="quote-form" role="form" method="post" action="/quick_quote">
            <!-- text input -->
            <div class="form-group">
                <label>Name</label>
                <input type="text" required aria-required="true" class="form-control" placeholder="John Doe" name="name"/>
            </div>

            <div class="form-group">
                <label>Mobile No.</label>
                <input type="text" required aria-required="true" class="form-control" placeholder="91-2345678901" name="phone"/>
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="text" required aria-required="true" class="form-control" placeholder="john.doe@example.org" name="email"/>
            </div>

            <div class="form-group">
                <label>Moving From</label>
                <input type="text" required aria-required="true" class="form-control" placeholder="Bangalore" name="moving_from"/>
            </div>

            <div class="form-group">
                <label>Moving To</label>
                <input type="text" required aria-required="true" class="form-control" placeholder="New Delhi" name="moving_to"/>
            </div>

            <!-- textarea -->
            <div class="form-group">
                <label>Description</label>
                <textarea class="form-control" rows="3" placeholder="Any special instructions." name="description"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-info btn-raised js-btn-quote">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>