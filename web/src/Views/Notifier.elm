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
                    , H.p [] [ H.label [] [ H.text "First Name: " ], H.span [] [ H.text "<<fname>>" ] ]
                    , H.p [] [ H.label [] [ H.text "Last Name: " ], H.span [] [ H.text "<<Lname>>" ] ]
                    , H.p [] [ H.label [] [ H.text "Birth Date: " ], H.span [] [ H.text "<<bdate>>" ] ]
                    , H.p [] [ H.label [] [ H.text "CNP: " ], H.span [] [ H.text "<<cnp>>" ] ]
                    , H.p [] [ H.label [] [ H.text "Total Debt to State: " ], H.span [] [ H.text "125485lei" ] ]
                    ]
                , H.article [ A.class "payment-notice-list" ]
                    [ H.h3 [] [ H.text "Previous Court Decisions Which Refund Debtor" ]
                    , H.div [ A.class "payment-notice" ]
                        [ H.p [] [ H.label [] [ H.text "Court Decision ID (complaint number): " ], H.span [] [ H.text "<<fname>>" ] ]
                        , H.p [] [ H.label [] [ H.text "Amount to Pay: 50000lei" ], H.span [] [ H.text "<<fname>>" ] ]
                        , H.p [] [ H.label [] [ H.text "Payment Due Date: mm/dd/yyyy" ], H.span [] [ H.text "<<fname>>" ] ]
                        , H.p [] [ H.label [] [ H.text "Paid in bank account: <<bank account>>" ], H.span [] [ H.text "<<fname>>" ] ]
                        , H.p [] [ H.label [] [ H.text "Designated person to receive money: <<designated>>" ], H.span [] [ H.text "<<fname>>" ] ]
                        , H.p [] [ H.label [] [ H.text "Decision Text Body: " ], H.span [] [ H.text "<<fname>>" ] ]
                        , H.p [] [ H.label [] [ H.text "Updated here by: <<notifier-author>> and Watchers notified" ], H.span [] [ H.text "<<fname>>" ] ]
                        , H.p [] [ H.label [] [ H.text "Other <<notifier-author>> Notes: " ], H.span [] [ H.text "<<fname>>" ] ]
                        ]
                    , H.div [ A.class "payment-notice" ]
                        [ H.p [] [ H.label [] [ H.text "Court Decision ID (complaint number): " ], H.span [] [ H.text "1112451245" ] ]
                        , H.p [] [ H.label [] [ H.text "Amount to Pay: " ], H.span [] [ H.text "70000lei" ] ]
                        , H.p [] [ H.label [] [ H.text "Payment Due Date: " ], H.span [] [ H.text "mm/dd/yyyy" ] ]
                        , H.p [] [ H.label [] [ H.text "Paid in bank account: " ], H.span [] [ H.text "<<bank account>>" ] ]
                        , H.p [] [ H.label [] [ H.text "Designated person to receive money: " ], H.span [] [ H.text "<<designated>>" ] ]
                        , H.p [] [ H.label [] [ H.text "Decision Text Body: " ], H.span [] [ H.text "<<Lorem ipsum et dolor sit amet lk;dasovklewa>>" ] ]
                        , H.p [] [ H.label [] [ H.text "Updated here by: " ], H.span [] [ H.text "<<notifier-author>> and Watchers notified" ] ]
                        , H.p [] [ H.label [] [ H.text "Other <<notifier-author>> Notes: " ], H.span [] [ H.text "Lorem ipsum et dolor sit amet l;dsvkajeoa" ] ]
                        ]
                    ]
                , H.article [ A.class "payment-notice-form form-m" ]
                    [ H.h3 [] [ H.text "Notify Watchers about New Debtor Refund" ]
                    , H.input [ A.type' "text", A.placeholder "Court Decision ID" ] []
                    , H.input [ A.type' "text", A.placeholder "Amount to Pay" ] []
                    , H.input [ A.type' "date", A.placeholder "Due Date" ] []
                    , H.input [ A.type' "text", A.placeholder "Bank Account" ] []
                    , H.input [ A.type' "text", A.placeholder "Designated Person" ] []
                    , H.textarea [ A.placeholder "Decision Text Body" ] []
                    , H.textarea [ A.placeholder "Other Notes: " ] []
                    , H.button [ A.class "submit" ] [ H.text "Notify Watchers" ]
                    ]
                ]
            ]
        ]
