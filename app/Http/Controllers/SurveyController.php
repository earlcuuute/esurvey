<?php

namespace App\Http\Controllers;

use App\Question;
use App\QuestionChoice;
use App\QuestionType;
use App\Repositories\SurveyRepository;
use App\Response;
use App\Survey;
use App\SurveyPage;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\SurveyCategory;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Repositories\TaskRepository;
use Illuminate\Support\Facades\View;

class SurveyController extends Controller
{
    protected $surveys;

    public function __construct(SurveyRepository $surveys)
    {
        $this->middleware('auth');

        $this->surveys = $surveys;
    }

    public function index()
    {
        return view('survey.create', [
            'categories' => $this->getSurveyCategories(),
        ]);
    }

    public function create(Request $request)
    {
        $this->validate($request,[
            'survey_title' => 'required|max:250',
        ]);

        $survey = new Survey;

        DB::transaction(function() use ($request, $survey){
            $category = $request->category;
            if($request->category == -1){
                $category = null;
            }

            $survey->survey_title = $request->survey_title;
            $survey->user()->associate($request->user());
            $survey->category()->associate($category);

            $survey->save();

            $survey->pages()->create([
                'page_no' => 1,
            ]);

        });

        return redirect('/create/' .$survey->id);
    }

    public function store($id, Request $request) //storing the question
    {
        $this->validate($request, [
            'question_title' => 'required|max:250',
            'question_type' => 'required',
            'page_id' => 'required'
        ]);

        $survey = Survey::find($id);
        $page = SurveyPage::find($request->page_id);
        $type = QuestionType::find($request->question_type);

        switch ($request->manipulation_method){
            case "add":
                $question = new Question();
                $question->question_title = $request->question_title;

                //INCREMENT ORDER NUMBER
                $latestQuestion = $page->questions()->orderBy('order_no', 'desc')->first();
                $question->order_no = $latestQuestion == null ? 1 : $latestQuestion->order_no + 1;

                $question->surveyPage()->associate($page);
                $question->questiontype()->associate($type);

                DB::transaction(function() use($request, $question, $type){
                    $question->save();
                    $this->saveChoices($type, $question, $request->choices);
                });
                break;

            case "edit":
                $question = Question::find($request->question_id);
                DB::transaction(function() use($request, $question, $type){
                    QuestionChoice::where('question_id', $request->question_id)->delete();
                    $question->update([
                        'question_title' => $request->question_title,
                        'question_type_id' => $request->question_type,
                    ]);
                    $this->saveChoices($type, $question, $request->choices);
                });
                break;
        }

        $this->updateSurveyTimestamps($survey);
        return view('ajax.question', ['question' => $question]);
    }

    private function saveChoices($type, $question, $choices){
        if($type->has_choices){
            foreach ($choices as $label){
                $choice = new QuestionChoice();
                $choice->label = $label;
                $choice->question()->associate($question);
                $choice->save();
            }
        }
    }

    public function manipulateSurvey($id, Request $request){
        $survey = Survey::find($id);
        switch ($request->action){
            case 'add_page':
                $page = new SurveyPage();
                DB::transaction(function () use($survey, $request, $page){
                    //SORT PAGE NUMBERS
                    $newPage =  $request->page_no + 1;
                    SurveyPage::where('survey_id', $survey->id)
                                ->where('page_no', '>=', $newPage)
                                ->increment('page_no');
                    $page->page_no = $newPage;
                    $page->survey()->associate($survey);
                    $page->save();
                });

               /* return view('ajax.page', [
                    'page' => $page,
                    'survey' => $survey,
                    'question_types' => $this->getQuestionTypes()
                ]);*/
               return json_encode(array("id" => $page->id));
                break;
            case 'edit_page_title':
                SurveyPage::find($request->page_id)
                    ->update([
                        'page_title' => $request->page_title,
                        'page_description' => $request->page_description,
                    ]);
                break;
            case 'edit_survey_title':
                $survey->update([
                    'survey_title' => $request->survey_title,
                ]);
                break;
            default:
                //
        }
        $this->updateSurveyTimestamps($survey);
    }

    public function show($id)
    {
        $survey = Survey::find($id);
        return view('survey.edit', ['survey' => $survey]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Survey::destroy($id);

        return redirect('/home');
    }

    private function getSurveyCategories(){
        return SurveyCategory::where('category', '!=', 'Other')->orderBy('category','asc')->get();
    }

    private function getQuestionTypes(){
        return QuestionType::all();
    }

    private function updateSurveyTimestamps(Survey $survey){
        $survey->update([
            'updated_at' => Carbon::now(),
        ]);
    }

}
