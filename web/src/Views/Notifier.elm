module Views.Notifier exposing (..)

import Html as H exposing (Html)
import Html.Attributes as A


type Msg
    = SetName String
    | SetPassword String
    | Submit


type alias Model =
    { name : String
    , password : String
    }


debtorVerifier =
    H.section [ A.class "verify-debtor" ]
        [ H.input [ A.type' "search", A.placeholder "Search by CNP" ] []
        , H.div [ A.class "search-result" ]
            [ H.p [ A.class "clean" ] [ H.text "This person was not reported as debtor" ]
            , H.section [ A.class "debtor-found" ]
                [ H.article [ A.class "about-debtor" ]
                    [ H.h3 [] [ H.text "This person is currently a debtor" ]
                    , H.p [] [ H.text "Name: " ]
                    , H.p [] [ H.text "Surname: " ]
                    , H.p [] [ H.text "Birth Date: " ]
                    , H.p [] [ H.text "CNP: " ]
                    , H.p [] [ H.text "Total Debt to State: " ]
                    ]
                , H.article [ A.class "payment-notice-list" ]
                    [ H.h3 [] [ H.text "Previous Court Decisions Which Refund Debtor" ]
                    , H.p [] [ H.text "Court Decision ID (complaint number): 48854684" ]
                    , H.p [] [ H.text "Amount to Pay: 50000lei" ]
                    , H.p [] [ H.text "Payment Due Date: mm/dd/yyyy" ]
                    , H.p [] [ H.text "Paid in bank account: <<bank account>>" ]
                    , H.p [] [ H.text "Designated person to receive money: <<designated>>" ]
                    , H.p [] [ H.text "Decision Text Body: " ]
                    , H.p [] [ H.text "Updated here by: <<notifier-author>> and Watchers notified" ]
                    , H.p [] [ H.text "Other <<notifier-author>> Notes: " ]
                    ]
                , H.article [ A.class "payment-notice-form form-s" ]
                    [ H.input [ A.type' "text", A.placeholder "Court Decision ID" ] []
                    , H.input [ A.type' "text", A.placeholder "Amount to Pay" ] []
                    , H.input [ A.type' "date", A.placeholder "Due Date" ] []
                    , H.input [ A.type' "text", A.placeholder "Bank Account" ] []
                    , H.input [ A.type' "text", A.placeholder "Designated Person" ] []
                    , H.input [ A.type' "text", A.placeholder "Decision Text Body" ] []
                    , H.input [ A.type' "text", A.placeholder "Other Notes: " ] []
                    , H.button [ A.class "submit" ] [ H.text "Notify Watchers" ]
                    ]
                ]
            ]
        ]
