<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Oracle Database Administration Exam</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    @vite(['resources/js/app.js', 'resources/js/Timer.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
  <body>
<div class=" row container bg-light my-5 mx-auto pt-3 justify-content-center" id="background">
<div class="offset-md-3 mt-4" style="font-size: xx-large;"> Oracle Database Administration Exam</div>
@if($errors->any())
    <div class="alert alert-danger col-md-4 offset-md-4 mt-5 text-center">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
@endif
    <div class="text-start my-5 pt-4">
        <form action="{{route('makeQuestions')}}" method="post" enctype="multipart/form-data">
          @csrf
            <div class="row mb-1">
              <label for="QuestionTitle" class="col-md-2 col-form-label offset-md-2">Question Title</label>
              <div class="col-md-4">
                <input type="text" class="lightgray form-control border border-0  " id="QuestionTitle" name="QuestionTitle">
              </div>
            </div>
            <div class="row mb-1">
                <label for="QuestionImage" class="col-md-2 col-form-label offset-md-2">Question Image</label>
                <div class="col-md-4">
                  <input type="file" class="lightgray form-control border border-0 " id="QuestionImage" name="QuestionImage">
            </div>
              </div>
            <div class="row mb-1">
                <label for="QuestionText" class="col-md-2 col-form-label offset-md-2">Question Text</label>
                <div class="col-md-4">
                    <input type="text" class="lightgray form-control border border-0 " id="QuestionText" name="QuestionText">
                </div>
            </div>
            <div class="row mb-1">
                <label for="Type" class="col-md-2 col-form-label offset-md-2">Type</label>
                <div class="col-md-4">
                    <select class="lightgray form-control border border-0 " id="Type" name="Type">
                        <option value="" selected disabled>Select Type</option>
                        <option value="MCQ">MCQ</option>
                        <option value="MRQ">MRQ</option><!--Multiple Response Questions-->
                        <option value="Text">Text</option>
                    </select>
                    <!-- <input type="text" class="lightgray form-control border border-0 " id="Type" name="Type"> -->
                </div>
            </div>
            <hr class="w-75 mx-auto my-5">
            <div id="Choices"></div>
            <script>
              document.getElementById('Type').addEventListener('change', function() {
                let value = this.value;
                if (value === "MCQ" || value === "MRQ") {
                  document.getElementById('Choices').innerHTML = `
                    <div class="row mb-1">
                      <label for="Choice1" class="col-md-2 col-form-label offset-md-2">A :</label>
                      <div class="col-md-4">
                        <input type="text" class="lightgray form-control border border-0 " id="Choice1" name="Choices[]">
                      </div>
                    </div>
                    <div class="row mb-1">
                      <label for="Choice2" class="col-md-2 col-form-label offset-md-2">B :</label>
                      <div class="col-md-4">
                        <input type="text" class="lightgray form-control border border-0 " id="Choice2" name="Choices[]">
                      </div>
                    </div>
                    <div class="row mb-1">
                      <label for="Choice3" class="col-md-2 col-form-label offset-md-2">C :</label>
                      <div class="col-md-4">
                        <input type="text" class="lightgray form-control border border-0 " id="Choice3" name="Choices[]">
                      </div>
                    </div>
                    <div class="row mb-1">
                      <label for="Choice4" class="col-md-2 col-form-label offset-md-2">D :</label>
                      <div class="col-md-4">
                        <input type="text" class="lightgray form-control border border-0 " id="Choice4" name="Choices[]">
                      </div>
                    </div>
                    <div class="row mb-1">
                      <label for="Choice5" class="col-md-2 col-form-label offset-md-2">E :</label>
                      <div class="col-md-4">
                        <input type="text" class="lightgray form-control border border-0 " id="Choice5" name="Choices[]">
                      </div>
                    </div>
                  `;
                  bindChoiceChange();
                } else {
                  document.getElementById('Choices').innerHTML = 
                  `<div class="row mb-1" style='visibility:hidden'>
                      <label for="Choice1" class="col-md-2 col-form-label offset-md-2">A :</label>
                      <div class="col-md-4">
                        <input type="text" class="lightgray form-control border border-0 " id="Choice1" name="Choices[] value='' ">
                      </div>
                    </div>
                  `;
                }
              });
            </script>
            <hr class="w-75 mx-auto my-5">
            <div id="CorrectAnswer">
                <div class="row mb-1">
                    <label for="CorrectAnswer" class="col-md-2 col-form-label offset-md-2">Correct Answer</label>
                    <div class="col-md-4">
                        <select class="lightgray form-control border border-0 form-select " id="CorrectAnswer" name="CorrectAnswer">
                            <option value="" selected disabled>Correct Answer:</option>
                           
                        </select>
                        <!-- <input type="text" class="lightgray form-control border border-0 " id="Type" name="Type"> -->
                    </div>
                </div>
            </div>
            <script>
              function bindChoiceChange(){
                  document.querySelectorAll("input[name='Choices[]']").forEach((choice) => {
                    choice.addEventListener('change', function() {
                        let selectBox = document.querySelector('#CorrectAnswer select');

                        // Remove existing options to prevent duplicates
                        selectBox.innerHTML = '';

                        // Loop through all choices and add only non-empty values
                        document.querySelectorAll("input[name='Choices[]']").forEach((input) => {
                            if (input.value.trim() !== '') {
                                selectBox.innerHTML += `<option value="${input.value}">${input.value}</option>`;
                            }
                        });
                    });
                });
              }

               bindChoiceChange();
            </script>
            <div class="row justify-content-center mt-5"><button type="submit" class="btn btn-primary btn-sm col-md-1 rounded-pill" name="questions">Submit</button></div>
        </form>
    </div>
    <!-- <div class="row justify-content-center pb-5">*If a field does not apply to you, fill in N/A</div> -->
    
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>