module Admin.Model exposing (..)

import Http
import Json.Decode as JD exposing ((:=))
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
    | FetchFail Http.Error
    | FetchSucceed Organizations


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

        FetchFail err ->
            let
                foo =
                    Debug.log "err" err
            in
                state ! []

        FetchSucceed organizations ->
            { state | all = Debug.log "orgs" organizations } ! []


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


fetchOrgs : (Msg -> msg) -> String -> String -> Cmd msg
fetchOrgs tagger orgsUrl token =
    Http.send Http.defaultSettings
        { verb = "GET"
        , headers = [ ( "X-HGM-API-KEY", token ) ]
        , url = orgsUrl
        , body = Http.empty
        }
        |> Http.fromJson (JD.list orgDecoder)
        |> Task.perform FetchFail FetchSucceed
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
