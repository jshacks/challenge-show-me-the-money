module Auth.LoginForm exposing (..)

import Http
import Json.Decode as Decode exposing ((:=))
import Json.Encode as Encode
import Task


type alias State =
    { email : String
    , password : String
    , token : String
    }


type Msg
    = SetEmail String
    | SetPassword String
    | Submit String
    | FetchFail Http.Error
    | FetchSucceed String


init : State
init =
    State "" "" ""


update : Msg -> State -> ( State, Cmd Msg )
update msg state =
    case msg of
        SetEmail email ->
            { state | email = email } ! []

        SetPassword password ->
            { state | password = password } ! []

        Submit loginUrl ->
            state ! [ submitLogin loginUrl state ]

        FetchFail err ->
            let
                foo =
                    Debug.log "error" err
            in
                state ! []

        FetchSucceed token ->
            { state | token = Debug.log "token" token } ! []


submitLogin : String -> State -> Cmd Msg
submitLogin loginUrl state =
    Http.post tokenDecoder loginUrl (loginPayload state)
        |> Task.perform FetchFail FetchSucceed


tokenDecoder : Decode.Decoder String
tokenDecoder =
    ("token" := Decode.string)


loginPayload : State -> Http.Body
loginPayload { email, password } =
    let
        encoder =
            Encode.object
                [ ( "email", Encode.string email )
                , ( "password", Encode.string password )
                ]
    in
        Http.string <| Encode.encode 0 encoder
