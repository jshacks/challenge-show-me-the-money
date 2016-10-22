module Admin.Model exposing (..)


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
