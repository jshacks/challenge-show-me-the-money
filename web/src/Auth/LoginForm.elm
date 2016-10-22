module Auth.LoginForm exposing (..)

import Http
import Json.Decode as Decode exposing ((:=))
import Json.Encode as Encode
import Task


type Role
    = Admin
    | Notifier
    | Watcher


type alias State =
    { email : String
    , password : String
    , token : String
    , role : Maybe Role
    }


type Msg
    = SetEmail String
    | SetPassword String
    | Submit String
    | FetchFail Http.Error
    | FetchSucceed ( String, Maybe Role )


init : State
init =
    State "" "" "" Nothing


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

        FetchSucceed ( token, role ) ->
            { state | token = token, role = role } ! []


submitLogin : String -> State -> Cmd Msg
submitLogin loginUrl state =
    Http.post responseDecoder loginUrl (loginPayload state)
        |> Task.perform FetchFail FetchSucceed


responseDecoder : Decode.Decoder ( String, Maybe Role )
responseDecoder =
    Decode.object2 (,)
        ("token" := Decode.string)
        ("role" := Decode.string `Decode.andThen` decodeRole)


decodeRole : String -> Decode.Decoder (Maybe Role)
decodeRole role =
    Decode.succeed (roleFromString role)


roleFromString : String -> Maybe Role
roleFromString roleAsString =
    case roleAsString of
        "Admin" ->
            Just Admin

        "Notifier" ->
            Just Notifier

        "Watcher" ->
            Just Watcher

        _ ->
            Nothing


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
