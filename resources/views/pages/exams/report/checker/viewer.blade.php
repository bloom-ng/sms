
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <link rel="stylesheet" href="/css/styles.css">
    <style> body {
                font-family: 'Nunito', sans-serif;

            }
            .rot{	-ms-transform:rotate(-90deg); -webkit-transform:rotate(-90deg); 
			        transform:rotate(-90deg);  	
                }
    </style>
    <title>{{$record->student->user->name}}</title>
</head>
<body>

    <div id="result_body" class="my-2 mx-3">

        <div id="result-head ">
            
            <div id="school-info my-2" class="row">
                <div class=" col-1" id="logo">
                    <img src="/storage/{{$settings->where('key','school.logo')->first()['value']}}"
                        height="100" width="50" alt=""  class=" ml-5">
                </div>
                <div class="col-11 ">
                     <h4 class=" text-center font-weight-bold text-uppercase" id="school-name">{{$settings->where('key','school.name')->first()['value']}}</h4>
                    <h6 class="text-center text-uppercase" id="school-address">{{$settings->where('key','school.address')->first()['value']}}</h6>
                    <p class="text-center text-muted text-uppercase font-italic" id="school-motto">Motto:{{$settings->where('key','school.motto')->first()['value']}}</p>
                </div>
               
            </div>
            <div id="exam-info ">
                <h5 class="pl-5 ml-5 text-center lead font-weight-bold text-uppercase ">
                    {{$exam->termText()}} Term {{$exam->session->start.'/'.$exam->session->end}} Session Report 
                </h5>
            </div>
            <table class="table table-borderless text-uppercase " style="font-size:0.85rem">
 
              <tbody class="font-weight-bolder" style="font-size:0.8rem">
                <tr>
                  <td colspan="2" class="p-0">Name: {{$record->student->user->name}}</td>
                  <td class="p-0 ">Class: {{$record->section->classes->name.' '}} 
                  {{strtolower(trim($record->section->name))=='general' || strtolower(trim($record->section->name))=='combined' ? ''
                                                                                                          : $record->section->name}}</td>
                  <td class="p-0">Gender: {{$record->student->gender}}</td>
                  <td class="p-0">Average: {{round($student_average,1)}}</td>
                </tr>
                <tr>
                  <td colspan="2" class="p-0">No. of times present: {{$attendance}}</td>
                  <td class="p-0">No. of times School Opened: {{$settings->where('key','times.school.opened')->first()['value']}}</td>
                  <td class="p-0">No. in class: {{$no_in_class}}</td>
                  <td class="p-0">Grade: {{App\Support\Helpers\Exam::getLetterScoreRemark($student_average)}}</td>
                </tr>
               
                
              </tbody>
            </table>
            
        </div>

        <div id="result-scores ">

        <div class="card card-outline card-secondary mt-2" style="font-size:0.85rem"></div>
        <div class="text-uppercase text-center text-muted my-2">Cognitive Ability</div>
            <table class="table text-uppercase table-striped " style="font-size:0.8rem">
                <tr class="text-uppercase  p-5  text-center">
                    <th class="text-left">Subjects</th>
                    @foreach (config('settings.cass') as $cass )
                        <th class="">{{$cass}}</th>
                    @endforeach
                    <th>Total</th>
                    <th class="rot  py-3">Class <br> Lowest</th>
                    <th class="rot py-3 ">Class <br> Highest</th>
                    <th class="rot py-3">Class <br> Average</th>
                    <th>Position</th>
                    <th>Grade</th>
                    <th>Remark</th>
                </tr>

                @foreach($marks as $mark)
                <tr class="text-center ">
                    <td class="text-left p-2">{{$mark->subject->name}}</td>
                    @foreach (config('settings.cass') as $cass )
                    <td class="p-2">{{$mark->{$cass} }}</td>
                    @endforeach
                    <td class="p-2">{{$mark->totalScore()}}</td>
                    <td class="p-2">{{$mark->subjectStat()->mini}}</td>
                    <td class="p-2">{{$mark->subjectStat()->maxi}}</td>
                    <td class="p-2">{{round($mark->subjectStat()->average,1)}}</td>
                    <td class="p-2">{{$mark->subjectPosition()}}</td>
                    <td class="p-2">{{App\Support\Helpers\Exam::getLetterScoreRemark($mark->totalScore())}}</td>
                    <td class="p-2">{{App\Support\Helpers\Exam::getWordScoreRemark($mark->totalScore())}}</td>
                    
                </tr>
                @endforeach
    
        </table>
        <div class="card card-outline card-secondary"></div>
        </div>

        <div class="" id="student-skills">
            <div class="card card-outline card-secondary mt-2"></div>
            <div class="text-uppercase text-center text-muted my-2">Behavioural Assessment</div>
            <div class="card card-outline card-secondary "></div>
            
            <table class="table table-striped">
                @foreach ($record->skills as $skill )
             
                @if ($loop->index % 3 == 0)
                    <tr>
                @endif
                <td class="py-0">
                    
                    <div class="row">
                        
                    <div class="w-50">{{$skill['name']}} </div> 
                    <div class="w-50">
                        @for($i=0;$i<$skill['value'];$i++)
                            &#x2605;
                        @endfor 
                    </div> 
                    
                    </div>
                
                </td>
                 @if ($loop->index == 2 || $loop->index == 5 || $loop->index == 8 || $loop->index == 11 )
                    </tr>
                @endif
                
                @endforeach

            </table>
            
            
            <!--<div class="row d-flex d-print-flex justify-content-between">-->
            <!--    @foreach ($record->skills as $skill )-->
                
            <!--    <div class="col-md-4  row d-print-flex">-->
            <!--        <div class="col-5">{{$skill['name']}} </div> -->
            <!--        <div class="col">-->
            <!--            @for($i=0;$i<$skill['value'];$i++)-->
            <!--                &#x2605;-->
            <!--            @endfor -->
            <!--        </div> -->
                    
            <!--    </div>-->
            <!--    @endforeach-->

            <!--</div>-->
        
        </div>
        
        <div class="my-3">
            @if($record->comment1 != null OR $record->comment1 != '' )
            <div class="text-uppercase h6 font-weight-bold">Remark: {{$record->comment1}}</div>
            @endif
            @if($record->comment2 != null OR $record->comment2 != '' )
            <div class="text-uppercase h6 font-weight-bold mt-2">Additional Remark: {{$record->comment2}}</div>
            @endif
        </div>
            <div class="text-right " id="logo">
                    <img src="/storage/{{$settings->where('key','school.signature')->first()['value']}}"
                        height="70" width="100" alt=""  class=" ml-5">
             </div>
            <div class="other-info text-right text-uppercase font-weight-bold">
                Next Term Resumes: {{$settings->where('key','next.term.begins')->first()['value']}}
            </div>
        <div class="card card-outline card-secondary mt-3"></div>
    </div>
    

    
   
</body>
</html>