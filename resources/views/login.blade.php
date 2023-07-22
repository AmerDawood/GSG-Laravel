
  <!doctype html>
  <html lang="en">
    <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Bootstrap demo</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    </head>
    <body>
        <section class="vh-100" style="background-color: #508bfc;">
             <form action="{{ route('login') }}" method="post">
                @csrf
          {{--
                @if (session()->has('email'))
                <div class="alert alert-error" role="alert">
                    From Component
                </div>
            @endif



          --}}

                <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card shadow-2-strong" style="border-radius: 1rem;">
                          <div class="card-body p-5 text-center">

                            <h3 class="mb-5">Sign in</h3>
                            @error('email')

                            <p class="alert alert-danger" role="alert">
                               {{ $message }}
                           </p>
                            @enderror

                            <div class="form-outline mb-4">
                              <input type="email" id="typeEmailX-2" value="" name="email" class="form-control form-control-lg" />
                              <label class="form-label" for="typeEmailX-2">Email</label>


                            </div>

                            <div class="form-outline mb-4">
                              <input type="password" id="typePasswordX-2" name="password" class="form-control form-control-lg" />
                              <label class="form-label" for="typePasswordX-2">Password</label>
                            </div>

                            <!-- Checkbox -->
                            <div class="form-check d-flex justify-content-start mb-4">
                              <input class="form-check-input" type="checkbox" value="" id="form1Example3" />
                              <label class="form-check-label" for="form1Example3"> Remember password </label>
                            </div>

                            <button class="btn btn-primary btn-lg btn-block" type="submit">Login</button>

                            <hr class="my-4">

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
             </form>
          </section>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    </body>
  </html>
