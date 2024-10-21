<?php 
/*  Objective
Let's start to add the basic functions to our Sportly webapp. First we need a possibility to add training sessions and get them back as list. This logic should implement in the TrainingController!
Scenario 1: Implement the create function.
First we implement the api endpoint to store new Trainings for a logged in user in the database. For this I have already implement the models for Training, User and Category in the Training.php and User.php Category.php (there are already three categories in the database) files.

When the user is send a POST request to the api endpoint /api/training with the following json body
{
    name: 'endurance run',
    category: 'Running',
    distance: 10.2
}
Then our function create is called and should return a JSON Response with Status 201.
Also it should store a new Training instance in the database. Don't forget to save the associated user for a training (It is the authenticated user which can be found in the $request parameter).
This should work for other valid POST requests.
Scenario 2: Implement Validation for create endpoint.
Now that we can store new Trainings, we should improve the data validation for this POST endpoint

When the user is send a POST request to the api endpoint /api/training with the following json body
{
    title: 'endurance run',
    category: 'Running',
}
Then our function create is called and should return a JSON Response with Status 422 because the distance field is missing.
Also it should not store a new Training instance in the database.
When the user is send a POST request to the api endpoint /api/training with the following json body
{
    title: 'endurance run',
    category: 'Running',
    distance: 10.2
}
Then our function create is called and should return a JSON Response with Status 422 because the title is send instead of the field name.
Also it should not store a new Training instance in the database.
When the user is send a POST request to the api endpoint /api/training with the following json body
{
    name: 'endurance run',
    category: 'Fencing',
    distance: 10.2
}
Then our function create is called and should return a JSON Response with Status 422 and the JSON body
{
    error: {message: 'category not exists'}
}
because there is no category Fencing in the database.
Also it should not store a new Training instance in the database.
The validation should work with other wrong JSON requests too.
Scenario 3: Getting all trainings.
Now that we can store valid trainings, we need an endpoint to get all associated trainings.

Given are a lot of Training sessions in the database.
When the user is send a GET request to the api endpoint /api/training
Then the index method is called and should return a JSON Response with status code 200.
It should return a list of all trainings which associated to the requesting user and have the category Running. Include the category data as embedded object in the response.
This should also work for other valid training data.
*/
namespace App\Http\Controllers;

use App\Category;
use App\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{

    public function create(Request $request)
    {
        $data = $request->json()->all();
        if(empty($data['distance']) || empty($data['name'])){
            return response()->json([],422);
        }
        $data['user_id'] = $request->user()->id;
        $category = Category::where('name', $data['category'])->first();
        if(empty($category)){
            return response()->json((object)['error' => ['message' => 'category not exists']],422);
        }
        $data['category_id'] = $category->id;
        unset($data['category']);
        
        $training = new Training();
        if(!empty($data['user_id'])){
            $training->forceFill($data);
            $training->save();
        }
        return response()->json([],201);
    }

    public function index(Request $request)
    {
        $trainings = Training::with('category')
        ->whereHas('category', function($query) {
                $query->where('name', 'Running');
            })
        ->where('user_id', $request->user()->id)
        ->get();
        return response()->json($trainings,200);
    }
}