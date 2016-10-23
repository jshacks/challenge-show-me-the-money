module Admin.Model exposing (..)

import Http
import Json.Decode as JD exposing ((:=))
import Json.Encode as JE
import Task


type Role
    = Admin
    | Notifier
    | Watcher


type alias Organization =
    { name : String
    , identifier : String
    , email : String
    , role : Role
    }


type alias Organizations =
    List Organization


type alias State =
    { all : Organizations
    , new : Organization
    }


type OrganizationMsg
    = SetName String
    | SetIdentifier String
    | SetEmail String
    | SetRole Role


type Msg
    = New OrganizationMsg
    | RequestFail Http.Error
    | FetchSucceed Organizations
    | Register String String
    | RegisterSucceed Organization


initOrganization : Organization
initOrganization =
    Organization "" "" "" Watcher


init : State
init =
    State [] initOrganization


update : Msg -> State -> ( State, Cmd Msg )
update msg state =
    case msg of
        New orgMsg ->
            { state | new = updateOrg' orgMsg state.new } ! []

        RequestFail err ->
            let
                foo =
                    Debug.log "err" err
            in
                state ! []

        FetchSucceed organizations ->
            { state | all = organizations } ! []

        Register registerOrgUrl token ->
            state ! [ registerOrg registerOrgUrl token (Debug.log "post" state.new) ]

        RegisterSucceed registerd ->
            { state | all = registerd :: state.all, new = initOrganization } ! []


updateOrg' : OrganizationMsg -> Organization -> Organization
updateOrg' msg organization =
    case msg of
        SetName name ->
            { organization | name = name }

        SetIdentifier identifier ->
            { organization | identifier = identifier }

        SetEmail email ->
            { organization | email = email }

        SetRole role ->
            { organization | role = role }


registerOrg : String -> String -> Organization -> Cmd Msg
registerOrg registerOrgUrl token org =
    Http.send Http.defaultSettings
        { verb = "POST"
        , headers = [ ( "X-HGM-API-KEY", token ) ]
        , url = registerOrgUrl
        , body = registerPayload org
        }
        |> Http.fromJson orgDecoder
        |> Task.perform RequestFail RegisterSucceed


registerPayload : Organization -> Http.Body
registerPayload { name, email, identifier, role } =
    let
        encoder =
            JE.object
                [ ( "name", JE.string name )
                , ( "email", JE.string email )
                , ( "identifier", JE.string identifier )
                , ( "role", JE.string <| toString role )
                ]
    in
        Http.string <| Debug.log "encoded" <| JE.encode 0 encoder


fetchOrgs : (Msg -> msg) -> String -> String -> Cmd msg
fetchOrgs tagger orgsUrl token =
    Http.send Http.defaultSettings
        { verb = "GET"
        , headers = [ ( "X-HGM-API-KEY", token ) ]
        , url = orgsUrl
        , body = Http.empty
        }
        |> Http.fromJson (JD.list orgDecoder)
        |> Task.perform RequestFail FetchSucceed
        |> Cmd.map tagger


orgDecoder : JD.Decoder Organization
orgDecoder =
    JD.object4 Organization
        ("name" := JD.string)
        ("identifier" := JD.string)
        ("email" := JD.string)
        ("role" := JD.string `JD.andThen` roleDecoder)


roleDecoder : String -> JD.Decoder Role
roleDecoder role =
    JD.succeed (roleFromString role)


roleFromString : String -> Role
roleFromString roleAsString =
    case roleAsString of
        "Notifier" ->
            Notifier

        _ ->
            Watcher
