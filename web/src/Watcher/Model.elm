module Watcher.Model exposing (..)

import Http
import Task
import Json.Decode as JD exposing ((:=))
import String


type alias State =
    { debtors : Debtors
    , newDebtor : Debtor
    }


type alias Debtors =
    List Debtor


type alias Debtor =
    { firstName : String
    , lastName : String
    , cnp : String
    , birthDate : String
    , birthPlace : String
    , debts : List Debt
    }


type alias Debt =
    { amount : Float
    }


init : State
init =
    State [] initDebtor


initDebtor : Debtor
initDebtor =
    Debtor "" "" "" "" "" []


type Msg
    = RequestFail Http.Error
    | FetchSucceed Debtors


update : Msg -> State -> ( State, Cmd Msg )
update msg state =
    case msg of
        RequestFail err ->
            let
                foo =
                    Debug.log "err" err
            in
                state ! []

        FetchSucceed debtors ->
            { state | debtors = Debug.log "debs" debtors } ! []


fetchDebtors : (Msg -> msg) -> String -> String -> Cmd msg
fetchDebtors tagger url token =
    Http.send Http.defaultSettings
        { verb = "GET"
        , headers = [ ( "X-HGM-API-KEY", token ) ]
        , url = url
        , body = Http.empty
        }
        |> Http.fromJson ("debtors" := JD.list debtorDecoder)
        |> Task.perform RequestFail FetchSucceed
        |> Cmd.map tagger


debtorDecoder : JD.Decoder Debtor
debtorDecoder =
    JD.object6 Debtor
        ("firstName" := JD.string)
        ("lastName" := JD.string)
        ("CNP" := JD.string)
        ("birthDate" := JD.string)
        ("birthPlace" := JD.string)
        ("debts" := JD.list debtDecoder)


debtDecoder : JD.Decoder Debt
debtDecoder =
    JD.object1 Debt
        ("amount" := JD.float)
